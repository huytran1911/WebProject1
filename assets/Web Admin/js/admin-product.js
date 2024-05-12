const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item=> {
	const li = item.parentElement;

	item.addEventListener('click', function () {
		allSideMenu.forEach(i=> {
			i.parentElement.classList.remove('active');
		})
		li.classList.add('active');
	})
});

// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})

const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
	if(window.innerWidth < 576) {
		e.preventDefault();
		searchForm.classList.toggle('show');
		if(searchForm.classList.contains('show')) {
			searchButtonIcon.classList.replace('bx-search', 'bx-x');
		} else {
			searchButtonIcon.classList.replace('bx-x', 'bx-search');
		}
	}
})

if(window.innerWidth < 768) {
	sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
	searchButtonIcon.classList.replace('bx-x', 'bx-search');
	searchForm.classList.remove('show');
}

window.addEventListener('resize', function () {
	if(this.innerWidth > 576) {
		searchButtonIcon.classList.replace('bx-x', 'bx-search');
		searchForm.classList.remove('show');
	}
})

const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
	if(this.checked) {
		document.body.classList.add('dark');
	} else {
		document.body.classList.remove('dark');
	}
})






let products = [
    {image:'../../images/product images/chien luoc/alma mater 1tr750.webp' , id: '113' , name: 'Alma mater', menu: 'Chiến lược', price: '1.750.000', quantity: 20, locked: false },
    {image:'../../images/product images/gia dinh _ tre em/co co tich 350k.webp' , id: '114' ,name: 'Cờ cổ tích', menu: 'Gia đình & trẻ em', price: '350.000', quantity: 14, locked: false },
    {image:'../../images/product images/co/co tuong 50k.jpg',id: '115' , name: 'Cờ tướng', menu: 'Cờ', price: '50.000', quantity: 28, locked: false },
];

document.addEventListener('DOMContentLoaded', function() {
    displayProducts();
});

function cancelEditProduct() {
    const editProductModal = document.getElementById('editModal');
    editProductModal.style.display = 'none'; 
}

function displayProducts() {
    const tableBody = document.querySelector('#productTable tbody');
    tableBody.innerHTML = '';

    products.forEach((product, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            
            <td><img src="${product.image}" alt="Product Image" class="product-image"></td>
            <td>${product.id}</td>
            <td>${product.name}</td>
            <td>${product.menu}</td>
            <td>${product.price}</td>
            <td>${product.quantity}</td>
            <td>
                <button onclick="deleteProduct(${index})" class="${product.delete ? 'lock-btn locked' : 'lock-btn'}">
                    ${product.delete ? 'Bỏ khoá' : 'Xoá'}
                </button>
                <button class="edit-btn" onclick="editProduct(${index})" ${product.edit ? 'style="display:none;"' : ''}>Sửa</button>
                <div class="locked-overlay"></div>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

function deleteProduct(index) {
    const confirmation = confirm("Bạn có chắc muốn xoá sản phẩm này không?");
    products.splice(index, 1); 
    displayProducts(); 
}


function editProduct(index) {
    const editProductModal = document.getElementById('editModal');
    const editProductForm = document.getElementById('editForm');
    
    const editImageInput = document.getElementById('editImage');
    const imagePreview = document.getElementById('editImagePreview');
    const editImageStatusLabel = document.getElementById('editImageStatus');

    // Gán các giá trị sản phẩm đang chỉnh sửa vào form
    document.getElementById('editName').value = products[index].name;
    document.getElementById('editID').value = products[index].id;
    document.getElementById('editMenu').value = products[index].menu;
    document.getElementById('editPrice').value = products[index].price;
    document.getElementById('editQuantity').value = products[index].quantity;

    // Gán đường dẫn hình ảnh của sản phẩm vào imagePreview
    imagePreview.src = products[index].image;

    // Hiển thị modal chỉnh sửa
    editProductModal.style.display = 'block';

    // Xử lý sự kiện thay đổi hình ảnh
    editImageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                editImageStatusLabel.textContent = 'Đã chọn ảnh mới!'; // Hiển thị thông báo đã chọn ảnh
            };
            reader.readAsDataURL(file);
        }
    });

    // Xử lý khi submit form chỉnh sửa sản phẩm
    editProductForm.addEventListener('submit', function(event) {
        event.preventDefault();

        // Cập nhật thông tin sản phẩm
        products[index].name = document.getElementById('editName').value;
        products[index].id = document.getElementById('editID').value;
        products[index].menu = document.getElementById('editMenu').value;
        products[index].price = document.getElementById('editPrice').value;
        products[index].quantity = document.getElementById('editQuantity').value;

        // Đóng modal sau khi lưu thông tin và hiển thị lại sản phẩm
        editProductModal.style.display = 'none';
        alert('Thông tin sản phẩm đã được cập nhật!');
        displayProducts();
    });

    // Xử lý khi cancel chỉnh sửa sản phẩm
    const cancelEditButton = document.getElementById('cancelEdit');
    cancelEditButton.addEventListener('click', function(event) {
        event.preventDefault();
        cancelEditProduct();
    });
}


function addProduct() {
    const newImage = document.getElementById('addImage').value;
    const newID = document.getElementById('addID').value;
    const newName = document.getElementById('addName').value;
    const newMenu = document.getElementById('addMenu').value;
    const newPrice = document.getElementById('addPrice').value;
    const newQuantity = document.getElementById('addQuantity').value;

    const newProduct = {
        image: newImage,
        id: newID, // Sửa từ idp thành id
        name: newName,
        menu: newMenu,
        price: newPrice,
        quantity: newQuantity,
        locked: false // Không khóa mặc định  
    };

    products.push(newProduct);
    displayProducts();

}


document.addEventListener('DOMContentLoaded', function() {
    displayProducts(); // Hiển thị sản phẩm khi trang được tải

    const chooseImageButton = document.getElementById('chooseImageBtn');
    const addImageInput = document.getElementById('addImage');
    const addProductButton = document.querySelector('.add-btn');
    const addProductModal = document.getElementById('addModal');
    const addProductForm = document.getElementById('addForm');
    const cancelAddButton = document.getElementById('cancelAdd');
    const chooseEditImageButton = document.getElementById('chooseEditImageBtn');
    const editImageInput = document.getElementById('editImage');
    const editImageStatusLabel = document.getElementById('editImageStatus');

    chooseEditImageButton.addEventListener('click', function() {
        editImageInput.click(); // Khi nhấp nút, mở cửa sổ chọn tệp
    });

    editImageInput.addEventListener('change', function() {
        const selectedFile = editImageInput.files[0]; // Lấy tệp được chọn

        if (selectedFile) {
            // Xử lý tệp đã chọn ở đây (ví dụ: lưu đường dẫn hình ảnh vào biến)
            const selectedImageURL = URL.createObjectURL(selectedFile);
            console.log(`Đã chọn: ${selectedFile.name}`);
            editImageStatusLabel.textContent = 'Đã chọn ảnh mới!'; // Hiển thị thông báo
            // Có thể sử dụng selectedImageURL để hiển thị hình ảnh mới trên giao diện
        }
    });

    

    let selectedImageURL = '';

    chooseImageButton.addEventListener('click', function(event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của nút
        addImageInput.click(); // Khi nút chọn ảnh được nhấp, mở cửa sổ chọn tệp
    });

    addImageInput.addEventListener('change', function() {
        const selectedFile = addImageInput.files[0]; // Lấy tệp được chọn
        const imageStatus = document.getElementById('imageStatus');
        if (selectedFile) {
            selectedImageURL = URL.createObjectURL(selectedFile);
            console.log(`Đã chọn: ${selectedFile.name}`);
            imageStatus.textContent = 'Đã chọn ảnh!'; // Hiển thị thông báo
        }
    });

    addProductButton.addEventListener('click', function() {
        // Hiển thị modal để chỉnh sửa thông tin sản phẩm
        addProductModal.style.display = 'block';
    });

    addProductForm.addEventListener('submit', function(event) {
        event.preventDefault();

        // Tạo một đối tượng mới từ thông tin nhập vào
        const newProduct = {
            image: selectedImageURL, // Sử dụng đường dẫn hình ảnh đã chọn
            id: document.getElementById('addID').value,
            name: document.getElementById('addName').value,
            menu: document.getElementById('addMenu').value,
            price: document.getElementById('addPrice').value,
            quantity: document.getElementById('addQuantity').value,
            locked: false // Mặc định không khóa sản phẩm
        };

        // Thêm sản phẩm vào danh sách
        products.push(newProduct);

        // Hiển thị lại danh sách sản phẩm sau khi thêm
        displayProducts();

        // Đóng modal sau khi thêm sản phẩm và reset form
        addProductModal.style.display = 'none';
        addProductForm.reset();

        // Đặt lại đường dẫn hình ảnh đã chọn
        selectedImageURL = '';
    });

    cancelAddButton.addEventListener('click', function(event) {
        event.preventDefault();
        // Đóng modal và reset form nếu hủy thêm sản phẩm
        addProductModal.style.display = 'none';
        addProductForm.reset();

        // Đặt lại đường dẫn hình ảnh đã chọn
        selectedImageURL = '';
    });
});



