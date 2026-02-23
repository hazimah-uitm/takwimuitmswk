<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventAttachment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $eventList = Event::latest()->paginate($perPage);

        return view('pages.event.index', [
            'eventList' => $eventList,
            'perPage'   => $perPage,
        ]);
    }

    public function create()
    {
        return view('pages.event.create', [
            'save_route' => route('event.store'),
            'str_mode'   => 'Tambah',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_program'    => 'required|string|max:255',
            'mula_at'  => 'required|date_format:Y-m-d\TH:i',
            'tamat_at' => 'nullable|date_format:Y-m-d\TH:i|after_or_equal:mula_at',
            'lokasi'          => 'nullable|string|max:255',
            'penganjur'       => 'nullable|string|max:255',
            'peringkat'       => 'nullable|string|max:50',
            'agensi_terlibat' => 'nullable|string',
            'pegawai_rujukan' => 'nullable|string|max:255',
            'pautan'          => 'nullable|url',
            'catatan'         => 'nullable|string',
            'attachments'   => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'nama_program.required' => 'Sila isi nama program',
            'mula_at.required'      => 'Sila pilih tarikh & masa mula',
            'mula_at.date'          => 'Tarikh & masa mula tidak sah',
            'tamat_at.date'         => 'Tarikh & masa tamat tidak sah',
            'tamat_at.after_or_equal' => 'Tarikh tamat mesti sama atau selepas tarikh mula',
            'pautan.url'            => 'Format pautan tidak sah (pastikan bermula https://)',
        ]);

        $event = new Event();

        $event->nama_program    = trim($request->nama_program);
        $event->created_by = auth()->id();
        $event->mula_at  = Carbon::createFromFormat('Y-m-d\TH:i', $request->mula_at)->format('Y-m-d H:i:s');
        $event->tamat_at = $request->tamat_at
            ? Carbon::createFromFormat('Y-m-d\TH:i', $request->tamat_at)->format('Y-m-d H:i:s')
            : null;
        $event->lokasi          = $request->lokasi ? trim($request->lokasi) : null;
        $event->penganjur       = $request->penganjur ? trim($request->penganjur) : null;
        $event->peringkat       = $request->peringkat ? trim($request->peringkat) : null;
        $event->agensi_terlibat = $request->agensi_terlibat ? trim($request->agensi_terlibat) : null;
        $event->pegawai_rujukan = $request->pegawai_rujukan ? trim($request->pegawai_rujukan) : null;
        $event->pautan          = $request->pautan ? trim($request->pautan) : null;
        $event->catatan         = $request->catatan ? trim($request->catatan) : null;

        $event->save();

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {

                $path = $file->store('event_attachments', 'public');

                EventAttachment::create([
                    'event_id'  => $event->id,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('event')->with('success', 'Maklumat berjaya disimpan');
    }

    public function show($id)
    {
        $event = Event::with('creator')->findOrFail($id);

        return view('pages.event.view', [
            'event' => $event,
        ]);
    }

    public function edit(Request $request, $id)
    {
        return view('pages.event.edit', [
            'save_route' => route('event.update', $id),
            'str_mode'   => 'Kemas Kini',
            'event'      => Event::findOrFail($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_program'    => 'required|string|max:255',
            'mula_at'  => 'required|date_format:Y-m-d\TH:i',
            'tamat_at' => 'nullable|date_format:Y-m-d\TH:i|after_or_equal:mula_at',
            'lokasi'          => 'nullable|string|max:255',
            'penganjur'       => 'nullable|string|max:255',
            'peringkat'       => 'nullable|string|max:50',
            'agensi_terlibat' => 'nullable|string',
            'pegawai_rujukan' => 'nullable|string|max:255',
            'pautan'          => 'nullable|url',
            'catatan'         => 'nullable|string',
            'attachments'   => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png|max:5120',
        ], [
            'nama_program.required' => 'Sila isi nama program',
            'mula_at.required'      => 'Sila pilih tarikh & masa mula',
            'mula_at.date'          => 'Tarikh & masa mula tidak sah',
            'tamat_at.date'         => 'Tarikh & masa tamat tidak sah',
            'tamat_at.after_or_equal' => 'Tarikh tamat mesti sama atau selepas tarikh mula',
            'pautan.url'            => 'Format pautan tidak sah (pastikan bermula http:// atau https://)',
        ]);

        $event = Event::findOrFail($id);

        $event->nama_program    = trim($request->nama_program);
        $event->mula_at  = Carbon::createFromFormat('Y-m-d\TH:i', $request->mula_at)->format('Y-m-d H:i:s');
        $event->tamat_at = $request->tamat_at
            ? Carbon::createFromFormat('Y-m-d\TH:i', $request->tamat_at)->format('Y-m-d H:i:s')
            : null;
        $event->lokasi          = $request->lokasi ? trim($request->lokasi) : null;
        $event->penganjur       = $request->penganjur ? trim($request->penganjur) : null;
        $event->peringkat       = $request->peringkat ? trim($request->peringkat) : null;
        $event->agensi_terlibat = $request->agensi_terlibat ? trim($request->agensi_terlibat) : null;
        $event->pegawai_rujukan = $request->pegawai_rujukan ? trim($request->pegawai_rujukan) : null;
        $event->pautan          = $request->pautan ? trim($request->pautan) : null;
        $event->catatan         = $request->catatan ? trim($request->catatan) : null;

        $event->save();

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('event_attachments', 'public');

                EventAttachment::create([
                    'event_id'  => $event->id,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('event')->with('success', 'Maklumat berjaya dikemaskini');
    }

    public function search(Request $request)
    {
        $search  = $request->input('search');
        $perPage = $request->input('perPage', 10);

        $query = Event::latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_program', 'LIKE', "%{$search}%")
                    ->orWhere('lokasi', 'LIKE', "%{$search}%")
                    ->orWhere('penganjur', 'LIKE', "%{$search}%")
                    ->orWhere('peringkat', 'LIKE', "%{$search}%")
                    ->orWhere('pegawai_rujukan', 'LIKE', "%{$search}%");
            });
        }

        $eventList = $query->paginate($perPage);

        return view('pages.event.index', [
            'eventList' => $eventList,
            'perPage'   => $perPage,
            'search'    => $search,
        ]);
    }

    public function deleteAttachment($id)
    {
        $att = EventAttachment::findOrFail($id);

        // padam fail fizikal
        if (!empty($att->file_path) && Storage::disk('public')->exists($att->file_path)) {
            Storage::disk('public')->delete($att->file_path);
        }

        $eventId = $att->event_id;

        // padam rekod DB
        $att->delete();

        return redirect()->route('event.edit', $eventId)->with('success', 'Lampiran berjaya dipadam');
    }

    public function destroy(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('event')->with('success', 'Maklumat berjaya dihapuskan');
    }

    public function trashList()
    {
        $trashList = Event::onlyTrashed()->latest()->paginate(10);

        return view('pages.event.trash', [
            'trashList' => $trashList,
        ]);
    }

    public function restore($id)
    {
        Event::withTrashed()->where('id', $id)->restore();

        return redirect()->route('event')->with('success', 'Maklumat berjaya dikembalikan');
    }

    public function forceDelete($id)
    {
        $event = Event::withTrashed()->findOrFail($id);
        $event->forceDelete();

        return redirect()->route('event.trash')->with('success', 'Maklumat berjaya dihapuskan sepenuhnya');
    }
}
