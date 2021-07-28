<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-lg btn-warning']) }}>
    {{ $slot }}
</button>
