@extends('layouts.admin')

@section('title','Dashboard Admin')

@section('content')
    <div class="cards">
        <div class="card">
            <div class="title">Clients</div>
            <div class="value">{{ $kpis['clients'] }}</div>
        </div>

        <div class="card">
            <div class="title">commande jour</div>
            <div class="value">{{ $kpis['orders_today'] }}</div>
        </div>

        <div class="card">
            <div class="title">reservations</div>
            <div class="value">{{ $kpis['reservations'] }}</div>
        </div>
    </div>

    <div class="block" style="min-height:70px"></div>

    <div class="block">
        <h3>Activites recentes</h3>

        @if(empty($activities))
            <div class="activity">
                <div class="left">
                    <div class="type">Information</div>
                    <div class="label">Aucune activité pour le moment</div>
                </div>
                <div class="when">—</div>
            </div>
        @else
            @foreach($activities as $a)
                <div class="activity">
                    <div class="left">
                        <div class="type">{{ $a['type'] }}</div>
                        <div class="label">{{ $a['label'] }}</div>
                    </div>
                    <div class="when">{{ \Carbon\Carbon::parse($a['when'])->diffForHumans() }}</div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
