<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.index');
    }

    public function events(Request $request)
    {
        $start = $request->input('start');
        $end   = $request->input('end');

        $query = Event::query();

        if ($start && $end) {
            // convert ISO -> 'Y-m-d H:i:s'
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
                'url' => route('event.show', $e->id),

                // 🎨 warna
                'backgroundColor' => $bg,
                'borderColor'     => $bg,
                'textColor'       => '#ffffff',
            ];
        });

        return response()->json($data);
    }
}
