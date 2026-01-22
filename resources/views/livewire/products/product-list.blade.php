<div class="mt-4 min-h-screen bg-[#FFFBEB]"
    style="background-image: radial-gradient(#F8B418 1px, transparent 1px); background-size: 24px 24px;">

    <div class="sticky top-4 z-20 mx-4">
        <div class="flex justify-center gap-3 p-3 bg-white rounded-full shadow-[4px_4px_0px_0px_#F8B418]">
            @if ($categories)
                @foreach ($categories as $category)
                    <button wire:click="filterByCategory({{ $category->id }})"
                        class="relative px-5 py-2 rounded-full font-black text-sm uppercase tracking-wide transition-all duration-200 border-2
                        {{ $activeCategoryId == $category->id
                            ? 'bg-[#E13220] text-white border-[#E13220] shadow-[2px_2px_0px_0px_#8a1c11] translate-y-0'
                            : 'bg-white text-[#F8B418] border-transparent hover:bg-[#FFF8E1] hover:scale-105'
                        }}">

                        <div class="flex items-center gap-2">
                            @if (stripos($category->name, 'snack') !== false)
                                <i class="fa-solid fa-burger {{ $activeCategoryId == $category->id ? 'animate-bounce' : '' }}"></i>
                            @else
                                <i class="fa-solid fa-glass-water {{ $activeCategoryId == $category->id ? 'animate-bounce' : '' }}"></i>
                            @endif
                            <span>{{ $category->name }}</span>
                        </div>
                    </button>
                @endforeach
            @endif
        </div>
    </div>

    <div class="grid grid-cols-2 gap-x-5 gap-y-32 pb-24 pt-24 px-5">
        @if ($products)
            @forelse($products as $product)
                <div class="even:mt-24 group perspective-1000">
                    <x-products.product-item :product="$product" />
                </div>
            @empty
                <div class="col-span-2 flex flex-col items-center justify-center py-12 bg-white border-4 border-dashed border-[#F8B418] rounded-3xl">
                    <i class="fa-solid fa-cookie-bite text-4xl text-[#F8B418] mb-3"></i>
                    <p class="font-bold text-[#F8B418] text-lg">Menu Kosong!</p>
                </div>
            @endforelse
        @else
            <p class="col-span-2 text-center text-gray-500 font-bold">Kategori ini kosong.</p>
        @endif
    </div>
</div>