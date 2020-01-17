<?php

namespace App\Http\Controllers;

use App\Classify;
use App\Broadcast;
use Illuminate\Http\Request;
use Sentinel;


class GameController extends Controller {
    public function classifyPage() {
        $data = array();
        return view('game.classify', $data);
    }

    public function gamePage() {
        $data = array();
        $data['recommendClassifies'] = Classify::recommendclassifies(4);
        return view('game.index', $data);
    }

    public function gameClassifyPage($classify) {
        $data = array();
        $data['classify'] = Classify::find($classify);
        return view('game.game-classify', $data);
    }

}