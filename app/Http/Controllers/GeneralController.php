<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Course;
use App\Models\CourseVersion;
use App\Models\Enrollment;
use App\Models\Instructor;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller
{
    protected $globalMessageId;

    public function __construct()
    {
        $this->globalMessageId = '2';
    }

    public function dash()
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $data = [];
            $data['students'] = User::where('role', 'student')->count();
            $data['instructors'] = User::where('role', 'instructor')->count();
            $data['courses'] = CourseVersion::all()->count();
            $data['categories'] = Category::all()->count();

            return view('admin.index', [
                'data' => $data,
            ]);
        } elseif ($user->hasRole('instructor')) {
            $instructor = Instructor::where('user_id', $user->id)->first();

            $courseIds = Course::where('instructor_id', $instructor->id)
                ->pluck('id');
            $enrollments = Enrollment::whereIn('course_id', $courseIds)
                ->distinct('student_id')
                ->count('student_id');

            $revenue = 0;
            $courses = Course::where('instructor_id', $instructor->id)->get();
            foreach ($courses as $course) {
                $enrollmentCount = Enrollment::where('course_id', $course->id)->count();
                $revenue += $enrollmentCount * $course->price;
            }

            $data = [
                'courses' => $courses->count(),
                'enrollments' => $enrollments,
                'revenue' => $revenue,
            ];

            return view('instructor.index', [
                'data' => $data,
            ]);
        }
        return redirect()->route('home');
    }

    public function inbox()
    {
        $user = Auth::user();
        $is_active = -1;
        $active_sidebar = false;
        $contactData = session('contact_data', []);
        $contactId = $contactData['contact_id'] ?? -1;
        $status = $contactData['status'] ?? null;
        if ($contactId != -1) {
            $contact = Contact::where('id', $contactId)->first();
            if ($contact) {
                session()->forget('contact_data');
                $is_active = $contact->id;
                $active_sidebar = true;
            }
        }

        $contacts = Contact::where('user_id', $user->id)
            ->get();

        $messages = [];
        $latestMessages = [];

        foreach ($contacts as $contact) {
            // Retrieve messages in descending order (newest first)
            $contactMessages = Message::where(function ($query) use ($user, $contact) {
                $query->where(function ($query) use ($user, $contact) {
                    $query->where('sender_id', $user->id)
                        ->where('receiver_id', $contact->contact_id);
                })->orWhere(function ($query) use ($user, $contact) {
                    $query->where('sender_id', $contact->contact_id)
                        ->where('receiver_id', $user->id);
                });
            })->orderBy('created_at', 'desc')->get();

            // Store messages by contact ID
            $messages[$contact->id] = $contactMessages;

            // Find the latest message for each contact
            /*$latestMessages[$contact->id] = $contactMessages->first();*/ // First message in descending order is the latest
        }

        $createdAt = [];
        foreach ($contacts as $contact) {
            $contact->new_messages = 0;
            foreach ($messages[$contact->id] as $message) {
                /*$createdAt[$message->id] = $this->formatCreatedAtTime($message->created_at);*/
                $message->formated_created_at = $this->formatCreatedAtTime($message->created_at);
                if ($message->status === 'sent') {
                    $contact->new_messages = $contact->new_messages + 1;
                }
            }
        }


        $latestMessagesTimes = [];
        foreach ($contacts as $contact) {
            foreach ($messages[$contact->id] as $message) {
                /*$latestMessages[$contact->id] = $message;
                $latestMessagesTimes[$contact->id] = $this->formatMessageDate($message->created_at);*/
                $contact->latestMessage = $message;
                $contact->latestMessage->formated_time = $this->formatMessageDate($message->created_at);
                break;
            }
        }

        $contacts = $contacts->sortByDesc(function ($contact) {
            return $contact->latestMessage ? $contact->latestMessage->created_at : now();
        });

        $newUsers = "";
        if ($user->role === 'instructor' || $user->role === 'student') {
            $newUsers = User::where('role', 'student')
                ->orWhere('role', 'instructor')
                ->get();
        } elseif ($user->role === 'admin') {
            $newUsers = User::all();
        }

        foreach ($newUsers as $newUser) {
            $is_contact = Contact::where('user_id', $user->id)
                ->where('contact_id', $newUser->id)
                ->first();
            if ($is_contact) {
                $newUser->contact_status = $is_contact->status;
                $newUser->contact_id = $is_contact->id;
            } else {
                $newUser->contact_status = 'new';
                $newUser->contact_id = -1;
            }
        }
        return view('home.inbox', [
            'users' => $newUsers,
            'contacts' => $contacts,
            'messages' => $messages,
            'is_active' => $is_active,
            'active_sidebar' => $active_sidebar,
            'createdAt' => $createdAt,
        ]);
    }

    public function update_status(Request $request)
    {
        $user = Auth::user();
        $contact_id = $request->input('contact_id');
        $status = $request->input('status');
        $contact = Contact::where('id', $contact_id)->first();

        if ($status === 'new_contact'){
            $newContact = Contact::where('user_id', $user->id)
                ->where('contact_id', $contact_id)
                ->first();

            if (!$newContact) {
                $newContact = new Contact();
                $newContact->user_id = $user->id;
                $newContact->contact_id = $contact_id;
            }
            $newContact->status = 'active';
            $newContact->save();

            session(['contact_data' => [
                'contact_id' => $newContact->id,
                'status' => 'new_contact',
            ]]);
        } elseif ($status === 'check_contact'){
            $newContact = Contact::where('user_id', $user->id)
                ->where('contact_id', $contact_id)
                ->first();

            if (!$newContact) {
                $newContact = new Contact();
                $newContact->user_id = $user->id;
                $newContact->contact_id = $contact_id;
            }
            $newContact->status = 'active';
            $newContact->save();

            if ($newContact->has_message) {
                $messages = Message::where('sender_id', $newContact->contact_id)
                    ->where('receiver_id', $user->id)->orderBy('created_at', 'asc')->get();

                foreach ($messages as $message) {
                    if ($message->status === 'sent') {
                        $message->status = 'read';
                        $message->save();
                    }
                }
                $newContact->has_message = false;
                $newContact->save();
            }

            session(['contact_data' => [
                'contact_id' => $newContact->id,
                'status' => 'check_contact',
            ]]);
        } elseif ($contact && User::where('id', $contact_id)) {
            if ($status === 'new_message') {
                $receiverContact = Contact::firstOrCreate([
                    'user_id' => $contact->contact_id,
                    'contact_id' => $user->id,
                ]);
                $receiverContact->has_message = true;
                $receiverContact->save();

                $message = new Message();
                $message->sender_id = $user->id;
                $message->receiver_id = $contact->contact_id;
                $message->content = $request->input('message_content');
                $message->save();

                session(['contact_data' => [
                    'contact_id' => $contact_id,
                    'status' => 'new_message',
                ]]);
            } elseif ($status === 'read_message') {
                if ($contact->has_message) {
                    $messages = Message::where('sender_id', $contact->contact_id)
                        ->where('receiver_id', $user->id)->orderBy('created_at', 'asc')->get();

                    foreach ($messages as $message) {
                        if ($message->status === 'sent') {
                            $message->status = 'read';
                            $message->save();
                        }
                    }
                    $contact->has_message = false;
                    $contact->save();

                    session(['contact_data' => [
                        'contact_id' => $contact_id,
                        'status' => 'read_message',
                    ]]);
                }
            } elseif ($status === 'mute') {
                $contact->is_muted = true;
                $contact->save();

                session(['contact_data' => [
                    'contact_id' => $contact_id,
                    'status' => 'mute',
                ]]);
            } elseif ($status === 'unmute') {
                $contact->is_muted = false;
                $contact->save();

                session(['contact_data' => [
                    'contact_id' => $contact_id,
                    'status' => 'unmute',
                ]]);
            } elseif ($status === 'favorite') {
                $contact->is_favorite = true;
                $contact->save();

                session(['contact_data' => [
                    'contact_id' => $contact_id,
                    'status' => 'favorite',
                ]]);
            } elseif ($status === 'unfavorite') {
                $contact->is_favorite = false;
                $contact->save();

                session(['contact_data' => [
                    'contact_id' => $contact_id,
                    'status' => 'unfavorite',
                ]]);
            } elseif ($status === 'archive') {
                $contact->status = 'archived';
                $contact->save();

                session(['contact_data' => [
                    'contact_id' => -1,
                    'status' => 'archive',
                ]]);
            } elseif ($status === 'unarchive') {
                $contact->status = 'active';
                $contact->save();

                session(['contact_data' => [
                    'contact_id' => $contact_id,
                    'status' => 'unarchive',
                ]]);
            } elseif ($status === 'unarchive_2') {
                $contact->status = 'active';
                $contact->save();

                session(['contact_data' => [
                    'contact_id' => $contact_id,
                    'status' => 'unarchive_2',
                ]]);
            } elseif ($status === 'unarchive_3') {
                $contact->status = 'active';
                $contact->save();

                session(['contact_data' => [
                    'contact_id' => $contact_id,
                    'status' => 'unarchive_3',
                ]]);
            } elseif ($status === 'add_removed_contact') {
                $contact->status = 'active';
                $contact->save();

                session(['contact_data' => [
                    'contact_id' => $contact_id,
                    'status' => 'add_removed_contact',
                ]]);
            } elseif ($status === 'add_removed_contact_2') {
                $contact->status = 'active';
                $contact->save();

                session(['contact_data' => [
                    'contact_id' => $contact_id,
                    'status' => 'add_removed_contact_2',
                ]]);
            } elseif ($status === 'remove') {
                $contact->status = 'removed';
                $contact->save();

                session(['contact_data' => [
                    'contact_id' => -1,
                    'status' => 'remove',
                ]]);
            } elseif ($status === 'remove_message') {
                $message_id = $request->input('message_id');
                $message = Message::where('id', $message_id)->first();
                if ($message) {
                    $message->status = 'removed';
                    $message->save();
                }

                session(['contact_data' => [
                    'contact_id' => $contact_id,
                    'status' => 'remove_message',
                ]]);
            } elseif ($status === 'clear') {
                $messages = Message::where(function ($query) use ($user, $contact) {
                    $query->where(function ($query) use ($user, $contact) {
                        $query->where('sender_id', $user->id)
                            ->where('receiver_id', $contact->contact_id);
                    })->orWhere(function ($query) use ($user, $contact) {
                        $query->where('sender_id', $contact->contact_id)
                            ->where('receiver_id', $user->id);
                    });
                })->orderBy('created_at', 'desc')->get();
                if ($messages->count() > 0) {
                    foreach ($messages as $message) {
                        $message->status = 'cleared';
                        $message->save();
                    }
                }

                session(['contact_data' => [
                    'contact_id' => $contact_id,
                    'status' => 'clear',
                ]]);
            }
        }
        return redirect()->route('inbox.index');
    }

    public function formatCreatedAtTime($createdAt)
    {
        $date = Carbon::parse($createdAt);
        $now = Carbon::now();

        if ($date->isToday()) {
            return $date->format('H:i');
        }

        if ($date->isYesterday()) {
            return 'Yesterday, ' . $date->format('H:i');
        }

        if ($date->year === $now->year) {
            return $date->format('d M, H:i');
        }

        return $date->format('d.m.Y - H:i');
    }

    public function formatMessageDate($date)
    {
        $now = Carbon::now();
        $createdAt = Carbon::parse($date);

        if ($createdAt->isToday()) {
            return $createdAt->format('H:i');
        } elseif ($createdAt->isYesterday()) {
            return 'Yesterday';
        } elseif ($createdAt->year == $now->year) {
            return $createdAt->format('d M'); // Example: 18 May
        } else {
            return $createdAt->format('d.m.Y'); // Example: 18.05.2024
        }
    }

/*echo "<pre>";
print_r($contacts);
echo "</pre>";*/
}
