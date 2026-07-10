<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn text-white fw-semibold px-4 py-2']) }} style="background-color: #2C7A78; border: none;" onmouseover="this.style.backgroundColor='#236360'" onmouseout="this.style.backgroundColor='#2C7A78'">
    {{ $slot }}
</button>
