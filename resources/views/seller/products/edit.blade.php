<x-app-layout>

    <link rel="stylesheet" href="https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.css">
    <script src="https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.js"></script>

    <div class="max-w-2xl mx-auto py-2 px-4">

        <!-- BACK TO MY PRODUCTS -->
        <a href="{{ route('seller.products.index') }}" class="inline-block mt-6 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                </path>
            </svg>
        </a>

        <h2 class="text-xl font-bold mb-4">Edit Product</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-xl mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4">
                <ul class="list-disc ml-5 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('seller.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- CURRENT IMAGES -->
            <div class="mt-6 mb-6">
                <label class="block mb-2 font-medium">Current Product Images</label>

                <p class="text-sm text-gray-500 mb-3">
                    These are the current images for this product. If you upload and crop new images below, they will replace all current images after saving.
                </p>

                <div class="flex gap-3 flex-wrap">
                    @forelse($product->images as $image)
                        <div class="relative border rounded-xl p-2 bg-white shadow-sm">
                            <img src="{{ \App\Support\ImageUrl::make($image->image_path, 'placeholder.png') }}"
                                class="w-24 h-24 object-cover rounded"
                                alt="{{ $product->name }}">

                            @if($loop->first)
                                <span class="absolute top-1 left-1 bg-green-600 text-white text-[10px] px-2 py-1 rounded-full">
                                    Cover
                                </span>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No images currently uploaded.</p>
                    @endforelse
                </div>
            </div>

            <!-- REPLACE IMAGES -->
            <div class="mt-6 mb-6">
                <label class="block mb-2 font-medium">Replace Product Images</label>

                <p class="text-red-600 mb-3 text-sm">
                    If you upload new images here, they will replace all existing product images after saving.
                    Crop every selected image before submitting.
                </p>

                <input
                    type="file"
                    id="imageInput"
                    name="images[]"
                    accept="image/*"
                    multiple
                    class="mb-4 block w-full border p-2 rounded-xl"
                >

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Crop Area -->
                    <div>
                        <img id="cropImage" class="max-w-full hidden rounded-lg border">
                    </div>

                </div>

                <!-- Controls -->
                <div class="mt-4 flex flex-wrap gap-2">
                    <button type="button" onclick="cropCurrent()" class="bg-black text-white px-4 py-2 rounded-3xl">
                        Crop Image
                    </button>

                    <button type="button" onclick="nextImage()" class="bg-gray-300 px-4 py-2 rounded-3xl">
                        Next
                    </button>
                </div>

                <p id="imageCounter" class="text-sm text-gray-500 mt-3"></p>

                <div id="croppedGallery" class="flex gap-3 mt-6 flex-wrap"></div>

                <div id="hiddenInputs"></div>

                @error('cropped_images')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <label class="block text-sm font-medium">Product Name</label>
            <input
                name="name"
                value="{{ old('name', $product->name) }}"
                class="border border-gray-400 p-2 w-full mb-4 rounded-xl focus:ring focus:ring-blue-300 focus:outline-none"
                required
            >

            <label class="block text-sm font-medium">Product Description</label>
            <textarea
                name="description"
                class="border border-gray-400 p-2 w-full mb-4 rounded-xl focus:ring focus:ring-blue-300 focus:outline-none"
                rows="5"
                required>{{ old('description', $product->description) }}</textarea>

            <label class="block text-sm font-medium">Product Price</label>
            <input
                name="price"
                type="number"
                step="0.01"
                value="{{ old('price', $product->price) }}"
                class="border border-gray-400 p-2 w-full mb-4 rounded-xl focus:ring focus:ring-blue-300 focus:outline-none"
                required
            >

            <label class="block text-sm font-medium">Stock Quantity</label>
            <input
                name="stock_quantity"
                type="number"
                value="{{ old('stock_quantity', $product->stock_quantity) }}"
                class="border border-gray-400 p-2 w-full mb-4 rounded-xl focus:ring focus:ring-blue-300 focus:outline-none"
                required
            >

            <label class="block text-sm font-medium">Product Category</label>
            <select
                name="category"
                class="w-full border border-gray-400 rounded-xl p-2 mb-4 focus:ring focus:ring-blue-300 focus:outline-none"
                required
            >
                <option value="">Select Category</option>

                @foreach(config('categories') as $main => $subs)
                    <optgroup label="{{ $main }}">
                        @foreach($subs as $sub)
                            <option value="{{ $sub }}" {{ old('category', $product->category) === $sub ? 'selected' : '' }}>
                                {{ $sub }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>

            <label class="block text-sm font-medium">Shipment Size</label>
            <select
                name="shipping_size"
                class="border border-gray-400 p-2 w-full mb-4 rounded-xl focus:ring focus:ring-blue-300 focus:outline-none"
                required
            >
                <option value="small" {{ old('shipping_size', $product->shipping_size) === 'small' ? 'selected' : '' }}>Small</option>
                <option value="medium" {{ old('shipping_size', $product->shipping_size) === 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="large" {{ old('shipping_size', $product->shipping_size) === 'large' ? 'selected' : '' }}>Large</option>
            </select>

            <label class="block text-sm font-medium">Product Condition</label>
            <select
                name="condition"
                class="border border-gray-400 p-2 w-full mb-4 rounded-xl focus:ring focus:ring-blue-300 focus:outline-none"
                required
            >
                <option value="new" {{ old('condition', $product->condition) === 'new' ? 'selected' : '' }}>New</option>
                <option value="second_hand" {{ old('condition', $product->condition) === 'second_hand' ? 'selected' : '' }}>Second Hand</option>
            </select>

            <!-- DISCOUNT -->
            <div>
                <label class="block text-sm font-medium">Discount (%)</label>
                <input
                    type="number"
                    name="discount_percentage"
                    value="{{ old('discount_percentage', $product->discount_percentage) }}"
                    class="w-full border border-gray-400 rounded-xl p-2 mb-4 focus:ring focus:ring-blue-300 focus:outline-none"
                    min="0"
                    max="90"
                >
            </div>

            <div>
                <label class="block text-sm font-medium">Discount Duration (hours)</label>
                <input
                    type="number"
                    name="discount_hours"
                    class="w-full border border-gray-400 rounded-xl p-2 mb-4 focus:ring focus:ring-blue-300 focus:outline-none"
                    placeholder="e.g. 24"
                    min="1"
                >

                @if($product->discount_ends_at)
                    <p class="text-xs text-gray-500 mb-4">
                        Current discount ends: {{ \Carbon\Carbon::parse($product->discount_ends_at)->format('d M Y H:i') }}
                    </p>
                @endif
            </div>

            <!-- FREE SHIPPING -->
            <div class="flex items-center gap-2 mt-3 mb-5">
                <input
                    type="checkbox"
                    class="rounded-full"
                    name="free_shipping"
                    value="1"
                    {{ old('free_shipping', $product->free_shipping) ? 'checked' : '' }}
                >
                <label>Free Shipping</label>
            </div>

            <button class="px-4 py-2 bg-white text-black border border-black rounded-3xl hover:bg-blue-300 transition shadow-md">
                Update
            </button>

        </form>

    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        let cropper = null;
        let files = [];
        let currentIndex = 0;
        let croppedImages = [];
        let coverIndex = 0;

        const imageInput = document.getElementById('imageInput');
        const cropImage = document.getElementById('cropImage');
        const gallery = document.getElementById('croppedGallery');
        const hiddenInputs = document.getElementById('hiddenInputs');
        const imageCounter = document.getElementById('imageCounter');

        imageInput.addEventListener('change', function (e) {
            files = Array.from(e.target.files || []);
            currentIndex = 0;
            croppedImages = [];
            coverIndex = 0;

            gallery.innerHTML = '';
            hiddenInputs.innerHTML = '';

            if (cropper) {
                cropper.destroy();
                cropper = null;
            }

            if (files.length > 0) {
                loadImage(files[currentIndex]);
            }

            updateCounter();
        });

        function loadImage(file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }

                cropImage.onload = function () {
                    if (typeof window.Cropper !== 'function') {
                        alert('Cropper failed to load correctly.');
                        return;
                    }

                    cropper = new window.Cropper(cropImage, {
                        aspectRatio: 649 / 648,
                        viewMode: 1,
                        autoCropArea: 1,
                        responsive: true,
                        preview: '#preview',
                    });
                };

                cropImage.src = e.target.result;
                cropImage.classList.remove('hidden');
            };

            reader.readAsDataURL(file);
            updateCounter();
        }

        window.cropCurrent = function () {
            if (!files.length) {
                alert('Select images first.');
                return;
            }

            if (!cropper) {
                alert('Cropper not ready yet.');
                return;
            }

            const canvas = cropper.getCroppedCanvas({
                width: 649,
                height: 648,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            if (!canvas) {
                alert('Failed to crop image.');
                return;
            }

            const base64 = canvas.toDataURL('image/jpeg', 0.9);
            croppedImages[currentIndex] = base64;

            renderGallery();
            saveHiddenInputs();
        };

        window.nextImage = function () {
            if (!files.length) {
                alert('Select images first.');
                return;
            }

            if (!croppedImages[currentIndex]) {
                alert('Crop this image first.');
                return;
            }

            currentIndex++;

            if (currentIndex < files.length) {
                loadImage(files[currentIndex]);
            } else {
                imageCounter.textContent = 'All selected images have been processed.';
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
                cropImage.classList.add('hidden');
            }

            updateCounter();
        };

        function renderGallery() {
            gallery.innerHTML = '';

            croppedImages.forEach((img, index) => {
                if (!img) return;

                const wrapper = document.createElement('div');
                wrapper.className = 'relative border rounded-xl p-2 bg-white shadow-sm';

                const image = document.createElement('img');
                image.src = img;
                image.className = 'w-24 h-24 object-cover rounded';

                const topRow = document.createElement('div');
                topRow.className = 'absolute top-1 left-1 right-1 flex justify-between items-start';

                const coverBadge = document.createElement('span');
                coverBadge.className = index === coverIndex
                    ? 'bg-green-600 text-white text-[10px] px-2 py-1 rounded-full'
                    : 'bg-gray-700 text-white text-[10px] px-2 py-1 rounded-full';

                coverBadge.textContent = index === coverIndex ? 'Cover' : `#${index + 1}`;

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'bg-red-600 text-white text-xs w-6 h-6 rounded-full shadow';
                removeBtn.innerHTML = '&times;';
                removeBtn.title = 'Remove image';
                removeBtn.addEventListener('click', function () {
                    removeImage(index);
                });

                topRow.appendChild(coverBadge);
                topRow.appendChild(removeBtn);

                const controls = document.createElement('div');
                controls.className = 'mt-2 flex flex-wrap gap-1';

                const coverBtn = document.createElement('button');
                coverBtn.type = 'button';
                coverBtn.className = 'text-xs px-2 py-1 rounded bg-black text-white';
                coverBtn.textContent = 'Set Cover';
                coverBtn.addEventListener('click', function () {
                    setCover(index);
                });

                const leftBtn = document.createElement('button');
                leftBtn.type = 'button';
                leftBtn.className = 'text-xs px-2 py-1 rounded bg-gray-200';
                leftBtn.textContent = 'Move Left';
                leftBtn.disabled = index === 0;
                leftBtn.addEventListener('click', function () {
                    moveImage(index, index - 1);
                });

                const rightBtn = document.createElement('button');
                rightBtn.type = 'button';
                rightBtn.className = 'text-xs px-2 py-1 rounded bg-gray-200';
                rightBtn.textContent = 'Move Right';
                rightBtn.disabled = index === croppedImages.length - 1;
                rightBtn.addEventListener('click', function () {
                    moveImage(index, index + 1);
                });

                controls.appendChild(coverBtn);
                controls.appendChild(leftBtn);
                controls.appendChild(rightBtn);

                wrapper.appendChild(topRow);
                wrapper.appendChild(image);
                wrapper.appendChild(controls);

                gallery.appendChild(wrapper);
            });
        }

        function saveHiddenInputs() {
            hiddenInputs.innerHTML = '';

            croppedImages.forEach((img) => {
                if (!img) return;

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'cropped_images[]';
                input.value = img;

                hiddenInputs.appendChild(input);
            });

            const coverInput = document.createElement('input');
            coverInput.type = 'hidden';
            coverInput.name = 'cover_index';
            coverInput.value = coverIndex;

            hiddenInputs.appendChild(coverInput);
        }

        function removeImage(index) {
            croppedImages.splice(index, 1);
            files.splice(index, 1);

            if (coverIndex === index) {
                coverIndex = 0;
            } else if (coverIndex > index) {
                coverIndex--;
            }

            if (files.length === 0) {
                currentIndex = 0;
                coverIndex = 0;

                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }

                cropImage.src = '';
                cropImage.classList.add('hidden');
                gallery.innerHTML = '';
                hiddenInputs.innerHTML = '';
                imageCounter.textContent = 'No images selected.';
                imageInput.value = '';
                return;
            }

            if (currentIndex >= files.length) {
                currentIndex = files.length - 1;
            }

            renderGallery();
            saveHiddenInputs();
            loadImage(files[currentIndex]);
            updateCounter();
        }

        function moveImage(from, to) {
            if (to < 0 || to >= croppedImages.length) return;

            [croppedImages[from], croppedImages[to]] = [croppedImages[to], croppedImages[from]];
            [files[from], files[to]] = [files[to], files[from]];

            if (coverIndex === from) {
                coverIndex = to;
            } else if (coverIndex === to) {
                coverIndex = from;
            }

            if (currentIndex === from) {
                currentIndex = to;
            } else if (currentIndex === to) {
                currentIndex = from;
            }

            renderGallery();
            saveHiddenInputs();
            updateCounter();
        }

        function setCover(index) {
            coverIndex = index;

            if (index !== 0) {
                [croppedImages[0], croppedImages[index]] = [croppedImages[index], croppedImages[0]];
                [files[0], files[index]] = [files[index], files[0]];

                if (currentIndex === 0) {
                    currentIndex = index;
                } else if (currentIndex === index) {
                    currentIndex = 0;
                }

                coverIndex = 0;
            }

            renderGallery();
            saveHiddenInputs();
            updateCounter();
        }

        function updateCounter() {
            if (!files.length) {
                imageCounter.textContent = 'No images selected.';
                return;
            }

            imageCounter.textContent = `Editing image ${currentIndex + 1} of ${files.length}`;
        }
    });
    </script>

</x-app-layout>