@extends('admin.dashboard')
@section('title', 'Upload Product')
@section('content')
<style>
    .color-input label {
        margin-right: 10px;
    }

    .colorInputs input {
        margin: 2px;
        font-size: 0.875rem;
        border: 2px;
        border-color: #3b82f6;
        color: black;

    }
</style>
<div class="mx-6 lg:mx-0 ">
    <div class="flex justify-start mt-14 mb-10 ml-20">
        <h3><strong class="text-3xl">Upload Product</strong></h3>
    </div>
    <form id="detailsForm" class="max-w-md mx-auto " method="POST" action="{{ route('uploadproduct') }}" enctype="multipart/form-data">
        @csrf
        <div class="relative z-0 w-full mb-5 mt-4 group">
            <input type="text" name="product_name" id="product_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
            <label for="product_name" name="product_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Product Name</label>
        </div>
        <div class="relative z-0 w-full mb-2 group">
            <input require type="text" name="price" id="price" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
            <label for="price" name="price" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Price</label>
        </div>
        <div id="detailsContainer">
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="details[]" id="detail_0" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                <label for="detail_0" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Detail</label>
            </div>
        </div>
        <button type="button" id="addDetailButton" class="block mb-2 mt-1 rounded-xl bg-gray-400 px-6 py-1 text-sm text-white transition hover:bg-gray-500">Add Detail</button>
        <!--  -->
        <div class="form-group flex">
            <label>
                <input class="size-4 rounded border-gray-300" type="checkbox" name="is_new" value="1">
                <span class="text-red-600 ml-3"><strong>New</strong></span>
            </label>
        </div>
        <div class="mt-4">
            <div class="w-full mr-5">
                <div class="">
                    <select id="gender" for="gender" name="gender" class="block w-full px-3 sm:px-3 lg:px-5 pt-2 pb-1 text-sm text-grey-darker border border-grey-lighter rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option hidden selected disabled>Choose a gender</option>
                        <option for="gender" value="Men">Men</option>
                        <option for="gender" value="Women">Women</option>
                        <option for="gender" value="Unisex">Unisex</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <div class="w-full mr-5">
                <div class="">
                    <select id="class" for="class" name="class" class="block w-full px-3 sm:px-3 lg:px-5 pt-2 pb-1 text-sm text-grey-darker border border-grey-lighter rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option hidden selected disabled>
                            Choose a class
                        </option>
                        <option for="class" value="clothes">
                            clothes
                        </option>
                        <option for="class" value="bag">bag</option>
                        <option for="class" value="hat">hat</option>
                        <option for="class" value="shoe">shoe</option>
                        <option for="class" value="accessory">
                            accessory
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="mt-2">
            <label for="start_datetime" class="text-sm">Start discount:</label>
            <input type="datetime-local" class="text-sm" id="start_datetime" name="start_datetime">
            <br>
            <label for="end_datetime" class="text-sm">End discount:</label>
            <input type="datetime-local" id="end_datetime" class="text-sm" name="end_datetime">
            <br>
            <div class="flex my-3">
                <input type="number" name="discountnumber" placeholder="Discount %" min="1" max="100" oninput="validity.valid||(value='');" class=" w-2/3  px-3 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" />
                |
                <input type="number" name="discountquantity" placeholder="Discount Quantity" min="0" oninput="validity.valid||(value='');" class=" w-2/3  px-3 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" />
            </div>
        </div>
        <div class="max-w-lg">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="image">Images</label>
            <input require class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="images" for="images" type="file" id="image-input" name="images[]" multiple>
        </div>
        <div class="colorInputs mt-3" id="colorInputs"> </div>
        <button class="block mr-2 rounded-xl bg-gray-400 px-8 py-1 text-sm text-white transition hover:bg-gray-500" type="button" onclick="addColorInput()">Add color</button>
        <div class="mt-3">
            <textarea class="w-full" name="description" id="editor"></textarea>
        </div>
        <!--  -->
        <div class="mb-5 mt-2 w-full">

            @if (session('success'))
            <div class="alert text-blue-600 alert-success">
                <strong>{{ session('success') }} </strong>
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-1">
                    @foreach ($errors->all() as $error)
                    <div class="mt-0 text-red-700 rounded-xl relative" role="alert">
                        <li class="block sm:inline text-xs">{{ $error }}</li>
                    </div>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="flex py-3 justify-start lg:flex lg:justify-start">
                <button type="submit" class="block mr-2 rounded-xl bg-gray-800 px-8 py-2 text-sm text-white transition hover:bg-black">Submit</button>
            </div>
    </form>
</div>
<script>
    ////
    document.addEventListener("DOMContentLoaded", function() {
        let detailIndex = 1;
        document.getElementById('addDetailButton').addEventListener('click', function() {
            const detailsContainer = document.getElementById('detailsContainer');
            const newDetailDiv = document.createElement('div');
            newDetailDiv.classList.add('relative', 'z-0', 'w-full', 'mb-5', 'group');
            newDetailDiv.innerHTML = `
                    <input type="text" name="details[]" id="detail_${detailIndex}" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                    <label for="detail_${detailIndex}" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Detail</label>
                `;
            detailsContainer.appendChild(newDetailDiv);
            detailIndex++;
        });
        ////
        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: "{{ route('upload.file') }}?_token={{ csrf_token() }}"
                },
                on: {
                    fileUploadRequest: function(evt) {
                        evt.preventDefault();
                        var responseData = evt.data.responseData;
                        var imageUrl = responseData.url;
                        $.ajax({
                            url: "{{ route('uploadproduct') }}",
                            method: 'POST',
                            data: {
                                editor: editor.getData(),
                                url: imageUrl
                            },
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function(response) {
                                console.log(response);
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    }
                }
            })
            .catch(error => {
                console.error(error);
            });
    });

    let colorCounter = 0;

    function addColorInput() {

        const colorInputsDiv = document.getElementById("colorInputs");
        const colorInputDiv = document.createElement("div");
        colorInputDiv.classList.add("color-input", "mb-4");
        const colorLabel = document.createElement("label");
        colorLabel.textContent = "Color:";
        const colorInput = document.createElement("input");
        colorInput.type = "text";
        colorInput.name = `colors[${colorCounter}]`;
        colorInputDiv.appendChild(colorLabel);
        colorInputDiv.appendChild(colorInput);
        const sizesDiv = document.createElement("div");
        sizesDiv.classList.add("sizes");
        sizesDiv.dataset.colorIndex = colorCounter;
        const addSizeButton = document.createElement("button");
        addSizeButton.type = "button";
        addSizeButton.textContent = "Add size";
        addSizeButton.classList.add("block", "rounded-xl", "text-white", "px-1.5", "py-1", "text-sm", "bg-gray-400", "border-gray-300", "hover:bg-gray-500");
        addSizeButton.onclick = function() {
            const colorIndex = parseInt(sizesDiv.dataset.colorIndex);
            addSizeInput(sizesDiv, colorIndex);
        };
        colorInputDiv.appendChild(sizesDiv);
        colorInputDiv.appendChild(addSizeButton);
        colorInputsDiv.appendChild(colorInputDiv);
        colorCounter++;
    }

    function addSizeInput(sizesDiv, colorIndex) {
        const sizeDiv = document.createElement("div");
        sizeDiv.classList.add("size-input", "mt-2");
        const sizeLabel = document.createElement("label");
        sizeLabel.textContent = "Size:";
        const sizeInput = document.createElement("input");
        sizeInput.type = "text";
        const quantityLabel = document.createElement("label");
        quantityLabel.textContent = "Quantity:";
        const quantityInput = document.createElement("input");
        quantityInput.type = "number";
        sizeInput.oninput = function() {
            quantityInput.name = `quantities[${colorIndex}][${sizeInput.value}]`;
        };
        sizeDiv.appendChild(sizeLabel);
        sizeDiv.appendChild(sizeInput);
        sizeDiv.appendChild(quantityLabel);
        sizeDiv.appendChild(quantityInput);
        sizesDiv.appendChild(sizeDiv);
    }
</script>
@endsection