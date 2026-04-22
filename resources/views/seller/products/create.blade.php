<link rel="stylesheet" href="https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.css">
<script src="https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.js"></script>
<x-app-layout>

    <div class="max-w-2xl mx-auto mt-10 mb-4">

        <h2 class="text-xl font-bold mb-4">Add Product</h2>

        <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mt-4">
                <label class="block mb-2 font-medium">Product Images:</label>
                <p class="text-red-600 mb-3">
                    Ensure you select and edit the correct images, 
                    as you will not be able to edit or delete the images once the product is created! 
                    Ensure that you DO NOT upload images with transparent backgrounds! 
                </p>

                <input
                    type="file" id="imageInput" name="images[]" accept="image/*" 
                            multiple class="mb-4 block w-full border p-2 rounded-xl">

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

                <!-- Current position -->
                <p id="imageCounter" class="text-sm text-gray-500 mt-3"></p>

                <!-- Cropped images preview -->
                <div id="croppedGallery" class="flex gap-3 mt-6 flex-wrap"></div>

                <!-- Hidden container for all cropped images -->
                <div id="hiddenInputs"></div>

                @error('cropped_images')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <input name="name" placeholder="Name" class="border p-2 w-full mb-2 mt-4 rounded-xl">

            <textarea name="description" placeholder="Description" class="border p-2 w-full mb-2 rounded-xl"></textarea>

            <input name="price" type="number" step="0.01" placeholder="Price" class="border p-2 w-full mb-2 rounded-xl">

            <input name="stock_quantity" type="number" placeholder="Stock" class="border p-2 w-full mb-2 rounded-xl">

            <select name="category" class="w-full border rounded-xl p-2 mb-4">
                <option value="">Select Category</option>
                @foreach(config('categories') as $main => $subs)
                    <optgroup label="{{ $main }}">
                        @foreach($subs as $sub)
                            <option value="{{ $sub }}">{{ $sub }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>

            <select name="condition" class="border p-2 w-full mb-4 rounded-xl">
                <option value="new">New</option>
                <option value="second_hand">Second Hand</option>
            </select>

            <button class="bg-white text-black border border-gray-400 rounded-3xl hover:bg-blue-300 transition shadow-md px-4 py-2">
                Save Product Listing
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
                    leftBtn.textContent = 'Move to Left';
                    leftBtn.disabled = index === 0;
                    leftBtn.addEventListener('click', function () {
                        moveImage(index, index - 1);
                    });

                    const rightBtn = document.createElement('button');
                    rightBtn.type = 'button';
                    rightBtn.className = 'text-xs px-2 py-1 rounded bg-gray-200';
                    rightBtn.textContent = 'Move to Right';
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
