<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\TableStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Reservation;
use App\Models\Table;
use App\Rules\DateBetween;
use App\Rules\TimeBetween;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReservationController extends Controller
{
    public function stepOne(Request $request)
    {
        $reservation = $request->session()->get('reservation');
        $min_date = Carbon::today();
        $max_date = Carbon::now()->addWeek();
        return view('reservations.step-one', compact('reservation', 'min_date', 'max_date'));
    }

    public function storeStepOne(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'],
            'res_date' => ['required', 'date', new DateBetween, new TimeBetween],
            'tel_number' => ['required'],
            'guest_number' => ['required'],
        ]);

        $reservation = $request->session()->get('reservation', new Reservation());
        $reservation->fill($validated);
        $request->session()->put('reservation', $reservation);

        return to_route('reservations.step.two');
    }

    public function stepTwo(Request $request)
    {
        $reservation = $request->session()->get('reservation');
        $categories = Category::all();
        $allMenus = \App\Models\Menu::pluck('name', 'id');

        // Ambil kategori yang dipilih dari input GET atau dari session (biar tetap setelah reload)
        $selectedCategoryId = $request->input('category_id', session('selected_category_id'));
        $menus = [];
        if ($selectedCategoryId) {
            $category = Category::find($selectedCategoryId);
            $menus = $category ? $category->menus : [];
            session(['selected_category_id' => $selectedCategoryId]);
        }

        // Ambil meja yang tersedia pada tanggal tersebut
        $res_table_ids = Reservation::orderBy('res_date')->get()->filter(function ($value) use ($reservation) {
            return $value->res_date->format('Y-m-d') == $reservation->res_date->format('Y-m-d');
        })->pluck('table_id');
        $tables = Table::where('status', TableStatus::Available)
            ->where('guest_number', '>=', $reservation->guest_number)
            ->whereNotIn('id', $res_table_ids)->get();

        return view('reservations.step-two', compact('reservation', 'tables', 'categories', 'menus', 'selectedCategoryId', 'allMenus'));
    }

    public function storeStepTwo(Request $request)
    {
        $validated = $request->validate([
            'table_id' => ['required'],
            'menu_id' => ['required', 'array'],
            'menu_id.*' => ['exists:menus,id'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'integer', 'min:1'],
        ]);

        $reservation = $request->session()->get('reservation');
        $reservation->fill($validated);
        $reservation->save();

        // Siapkan data sinkronisasi: [menu_id => ['quantity' => jumlah]]
        $syncData = [];
        foreach ($request->menu_id as $menuId) {
            $syncData[$menuId] = [
                'quantity' => $request->quantity[$menuId] ?? 1,
            ];
        }
        $reservation->menus()->sync($syncData);

        $request->session()->forget('reservation');
        $request->session()->forget('selected_category_id');
        return to_route('thankyou', ['reservation' => $reservation->id]);
    }

    public function printReceipt(Reservation $reservation)
    {
        // Ambil data relasi jika perlu, misal menu dan meja
        $reservation->load('menus', 'table');

        $pdf = Pdf::loadView('reservations.receipt', compact('reservation'));
        return $pdf->download('struk-reservasi-' . $reservation->id . '.pdf');
    }

    public function thankyou(Reservation $reservation)
    {
        return view('thankyou', compact('reservation'));
    }
}
