@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-[#E6E6E6] focus:border-primary-mint focus:ring-primary-mint rounded-md']) }}>
