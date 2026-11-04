<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $filter = (string) $request->query('filter');

        $messages = ContactMessage::query()
            ->when($filter === 'baru', fn ($q) => $q->unread())
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $unreadCount = ContactMessage::unread()->count();

        return view('admin.pesan.index', compact('messages', 'filter', 'unreadCount'));
    }

    public function show(ContactMessage $message)
    {
        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.pesan.show', compact('message'));
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.pesan.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
