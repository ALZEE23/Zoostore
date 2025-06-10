<x-layout>

    @foreach ($ratings as $rating)
    <div>
        <img src="{{ asset('storage/' . $rating->product->photo) }}"
                                                    alt="{{ $rating->name }}" width="100" />

        <h3>{{ $rating->product->namaproduk }}</h3>

        <p><strong>{{ $rating->user->username ?? 'user' }}</strong></p>

        <p>
            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $rating->rating)
                    ⭐
                @else
                    ☆
                @endif
            @endfor
        </p>

        <p>{{ $rating->comment }}</p>
    </div>
@endforeach
    </x-layout>
