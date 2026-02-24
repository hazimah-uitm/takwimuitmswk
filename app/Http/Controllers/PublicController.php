<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        return view('pages.utama.index');
    }

    public function events(Request $request)
    {
        $start = $request->input('start');
        $end   = $request->input('end');

        $query = Event::query();

        if ($start && $end) {
            $startDt = Carbon::parse($start)->format('Y-m-d H:i:s');
            $endDt   = Carbon::parse($end)->format('Y-m-d H:i:s');

            $query->where(function ($q) use ($startDt, $endDt) {
                $q->whereBetween('mula_at', [$startDt, $endDt])
                    ->orWhereBetween('tamat_at', [$startDt, $endDt])
                    ->orWhere(function ($q2) use ($startDt, $endDt) {
                        $q2->where('mula_at', '<=', $startDt)
                            ->whereNotNull('tamat_at')
                            ->where('tamat_at', '>=', $endDt);
                    });
            });
        }

        $events = $query->orderBy('mula_at', 'asc')->get();

        $data = $events->map(function ($e) {

            // ✅ Bright palette (ulang kitar bila banyak event, tapi setiap event ID akan pick lain)
            $palette = [
                '#2563EB',
                '#16A34A',
                '#DC2626',
                '#9333EA',
                '#0D9488',
                '#EA580C',
                '#DB2777',
                '#4F46E5',
                '#059669',
                '#B91C1C',
                '#7C3AED',
                '#0891B2',
                '#F59E0B',
                '#22C55E',
                '#EF4444',
            ];

            // ✅ guna ID (unik) supaya “setiap program/event lain warna”
            $index = ((int) $e->id) % count($palette);
            $bg = $palette[$index];

            return [
                'id'    => $e->id,
                'title' => $e->nama_program, // nama sahaja
                'start' => Carbon::parse($e->mula_at)->toIso8601String(),
                'end'   => $e->tamat_at ? Carbon::parse($e->tamat_at)->toIso8601String() : null,
                'url'   => route('public.event.show', $e->id),

                // 🎨 warna
                'backgroundColor' => $bg,
                'borderColor'     => $bg,
                'textColor'       => '#ffffff',
            ];
        });

        return response()->json($data);
    }

    public function eventShow($id)
    {
        $event = Event::with('creator')->findOrFail($id);

        return view('pages.utama.detail', compact('event'));
    }

    public function eventModal($id)
    {
        $event = Event::with(['creator', 'attachments'])->findOrFail($id);

        // prepare attachments
        $atts = collect($event->attachments)->map(function ($att) {
            $path = $att->file_path;
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif']);

            return [
                'file_path' => $path,
                'file_name' => basename($path),
                'ext' => $ext,
                'is_image' => $isImage,
                'url' => asset('public/storage/' . $path),
            ];
        })->values();

        return response()->json([
            'id' => $event->id,
            'nama_program' => $event->nama_program,
            'catatan' => $event->catatan,

            'mula_at' => $event->mula_at ? Carbon::parse($event->mula_at)->format('d M Y, H:i') : null,
            'tamat_at' => $event->tamat_at ? Carbon::parse($event->tamat_at)->format('d M Y, H:i') : null,

            'lokasi' => $event->lokasi,
            'penganjur' => $event->penganjur,
            'peringkat' => $event->peringkat,
            'agensi_terlibat' => $event->agensi_terlibat,
            'pegawai_rujukan' => $event->pegawai_rujukan,
            'pautan' => $event->pautan,

            'creator' => optional($event->creator)->name,
            'created_at' => $event->created_at ? $event->created_at->format('d/m/Y') : null,

            'attachments' => $atts,
            'detail_url' => route('public.event.show', $event->id),
        ]);
    }

    public function embed()
    {
        return view('pages.utama.embed');
    }
}
