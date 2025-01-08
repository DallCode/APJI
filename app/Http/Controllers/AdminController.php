<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class AdminController extends Controller
{
    public function dashboard() {
        return view('admin.dashboard');
    }

    public function event(Request $request)
    {
        $search = $request->input('search');

        // Menggunakan paginate() untuk mendukung pagination
        $event = Event::when($search, function ($query) use ($search) {
            return $query->where('nama_event', 'LIKE', "%{$search}%");
        })->paginate(10); // Sesuaikan jumlah per halaman (10)

        return view('admin.event', compact('event'));
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_event' => 'required|string',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string',
        ]);
    
        // Simpan data ke database
        \App\Models\Event::create($validated);
    
        return redirect()->route('admin.event')->with('success', 'Event created successfully.');
    }
    

    public function update(Request $request, $id_event)
    {
        $event = Event::findOrFail($id_event);

        $validated = $request->validate([
            'nama_event' => 'required|string',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string',
            'daftar_hadir' => 'nullable|string',
            'notulensi' => 'nullable|string',
            'dokumentasi' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('dokumentasi')) {
            $image = $request->file('dokumentasi');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imageData = file_get_contents($image->getRealPath());
            $event->dokumentasi = base64_encode($imageData);
        }

        $event->update([
            'nama_event' => $validated['nama_event'],
            'tanggal' => $validated['tanggal'],
            'lokasi' => $validated['lokasi'],
            'daftar_hadir' => $validated['daftar_hadir'],
            'notulensi' => $validated['notulensi'],
        ]);

        return redirect()->route('admin.event')->with('success', 'Event updated successfully.');
    }


    public function destroy($id_event)
    {
        $event = Event::findOrFail($id_event);
        $event->delete();

        return redirect()->route('admin.event')->with('success', 'Event deleted successfully.');
    }

    // Show event details
    public function show($id_event)
    {
        $event = Event::findOrFail($id_event);
        return response()->json($event);
    }
}
