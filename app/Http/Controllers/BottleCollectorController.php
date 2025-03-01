<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BottleCollectorController extends Controller
{
    public function calculateEarnings(Request $request)
    {
        $request->validate([
            'daily_expenses' => 'required|numeric|min:0',
            'expeditions' => 'required|array',
        ]);

        $dailyExpenses = $request->daily_expenses;
        $expeditions = $request->expeditions;

        $totalEarnings = 0;
        $daysCount = count($expeditions);

        foreach ($expeditions as $expedition) {
            list($hours, $path, $price) = explode(' ', $expedition);
            $hours = (int) $hours;
            $price = (float) $price;

            $pathLength = strlen($path);
            $loops = intdiv($hours, $pathLength);
            $remainingHours = $hours % $pathLength;

            $bottlesFound = substr_count($path, 'B') * $loops + substr_count(substr($path, 0, $remainingHours), 'B');
            $dailyEarnings = $bottlesFound * $price;

            $totalEarnings += $dailyEarnings;
        }

        $averageEarnings = $totalEarnings / $daysCount;
        $totalExpenses = $dailyExpenses * $daysCount;

        if ($averageEarnings > $dailyExpenses) {
            $result = "Good earnings. Extra money per day: " . number_format($averageEarnings - $dailyExpenses, 2);
        } else {
            $result = "Hard times. Money needed: " . number_format($totalExpenses - $totalEarnings, 2);
        }

        return response()->json(['result' => $result]);
    }
}
