<x-app-layout>

<div class="bg-gray-100 min-h-screen py-10">

    <div class="max-w-6xl mx-auto px-4">

        <div class="grid grid-cols-1 md:grid-cols-5 gap-8">

            <!-- LEFT: IMAGE SECTION -->
            <div class="md:col-span-3">

                <!-- MAIN IMAGE CONTAINER -->
                <div class="relative bg-white rounded-xl shadow overflow-hidden">

                    <div class="w-full h-auto overflow-hidden">
                        @if($product->images->isEmpty())
                            <img src="/placeholder.png"
                                 class="w-full h-full object-cover"
                                 alt="no image">
                        @else
                            <img id="mainImage"
                                 src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                 class="w-full h-full object-cover transition duration-300 cursor-zoom-in"
                                 onclick="openLightbox(currentIndex)">
                        @endif
                    </div>

                    <!-- LEFT -->
                    <button onclick="prevImage()"
                        class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white shadow rounded-full px-3 py-2">
                        ←
                    </button>

                    <!-- RIGHT -->
                    <button onclick="nextImage()"
                        class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white shadow rounded-full px-3 py-2">
                        →
                    </button>

                </div>

                <!-- THUMBNAILS -->
                <div class="flex gap-3 mt-4 overflow-x-auto">
                    @foreach($product->images as $index => $image)
                        <img 
                            src="{{ asset('storage/' . $image->image_path) }}"
                            class="w-20 h-20 object-cover rounded-lg cursor-pointer border hover:border-gray-400 transition"
                            onclick="changeImage({{ $index }})"
                        >
                    @endforeach
                </div>

            </div>

            <!-- RIGHT: PRODUCT DETAILS -->
            <div class="md:col-span-2 bg-white p-6 rounded-xl shadow space-y-4">

                <h2 class="text-2xl font-bold text-gray-800">
                    {{ $product->name }}
                </h2>

                <p class="text-gray-600 text-sm">
                    {{ $product->description }}
                </p>

                <p class="text-3xl font-bold text-blue-600">
                    R{{ number_format($product->price, 2) }}
                </p>

                <p class="text-sm text-gray-500">
                    Stock: {{ $product->stock_quantity }}
                </p>

                <form method="POST" action="{{ route('cart.add', $product) }}" class="space-y-3">
                @csrf

                <div class="flex items-center gap-3">
                    <button type="button" onclick="decreaseQty()" class="px-3 py-1 bg-gray-200 rounded">-</button>
                    <input id="qty" type="number" name="quantity" value="1"
                        class="border rounded w-16 text-center">
                    <button type="button" onclick="increaseQty()" class="px-3 py-1 bg-gray-200 rounded">+</button>
                </div>

                <button class="w-full bg-blue-600 text-white py-2 rounded mt-6">
                    Add to Cart
                </button>
                </form>

            </div>

        </div>

        <!-- RELATED PRODUCTS -->
        <div class="mt-12">
            <h3 class="text-xl font-bold mb-4">Related Products</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($related as $item)
                    @php $image = $item->images->first(); @endphp
                    <a href="/products/{{ $item->id }}" 
                       class="bg-white p-3 rounded-xl shadow-sm hover:shadow-md transition">
                        @if($image)
                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                 class="w-full h-40 object-cover rounded mb-2">
                        @else
                            <img src="/placeholder.png"
                                 class="w-full h-40 object-cover rounded mb-2">
                        @endif
                        <p class="font-semibold text-sm text-gray-800">{{ $item->name }}</p>
                        <p class="text-blue-600 font-bold">R{{ number_format($item->price, 2) }}</p>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</div>

<!-- LIGHTBOX MODAL -->
<div id="lightbox" class="fixed inset-0 bg-black/90 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-3xl w-full">
        <img id="lightboxImage" class="w-full max-h-[80vh] object-contain rounded shadow-lg">
        <button onclick="closeLightbox()" 
                class="absolute top-2 right-2 text-white text-3xl font-bold bg-black/50 rounded-full w-10 h-10 flex items-center justify-center hover:bg-black/70 transition">
            &times;
        </button>
    </div>
</div>

<script>
let images = @json($product->images->pluck('image_path')->map(fn($img) => asset('storage/' . $img)));
let currentIndex = 0;
let autoPlayInterval = null;

function updateImage() {
    if(images.length>0) {
        document.getElementById('mainImage').src = images[currentIndex];
    }
}

function changeImage(index) {
    currentIndex = index;
    updateImage();
}

function nextImage() {
    if(images.length === 0) return;
    currentIndex = (currentIndex + 1) % images.length;
    updateImage();
}

function prevImage() {
    if(images.length === 0) return;
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    updateImage();
}

// LIGHTBOX
function openLightbox(index) {
    currentIndex = index;
    document.getElementById('lightboxImage').src = images[currentIndex];
    document.getElementById('lightbox').classList.remove('hidden');
}

function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
}

// AUTO-PLAY
function startCarousel() {
    autoPlayInterval = setInterval(nextImage, 5000); // 5s
}
function stopCarousel() {
    clearInterval(autoPlayInterval);
}

document.getElementById('mainImage').addEventListener('mouseenter', stopCarousel);
document.getElementById('mainImage').addEventListener('mouseleave', startCarousel);
startCarousel();

// MOBILE SWIPE SUPPORT
let touchStartX = 0;
let touchEndX = 0;
const mainImageContainer = document.getElementById('mainImage');
mainImageContainer.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0].screenX; });
mainImageContainer.addEventListener('touchend', e => { 
    touchEndX = e.changedTouches[0].screenX;
    if(touchEndX < touchStartX - 30) nextImage();
    if(touchEndX > touchStartX + 30) prevImage();
});

// QUANTITY CONTROLS
function increaseQty(){ let input=document.getElementById('qty'); input.value=parseInt(input.value)+1; }
function decreaseQty(){ let input=document.getElementById('qty'); if(input.value>1) input.value--; }

</script>

</x-app-layout>