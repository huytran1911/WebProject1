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






let users = [
    { name: 'Trần Diệp Bảo Huy', email: 'huytran@gmail.com', phone: '123456789', address: '123 tp hcm', locked: false },
    { name: 'Đỗ Anh Triết', email: 'anhtriet@gmail.com', phone: '123456789', address: '123 tp hcm', locked: false },
    { name: 'Nguyễn Võ Minh Thư', email: 'minhthu@gmail.com', phone: '123456789', address: '123 tp hcm', locked: false },

];

document.addEventListener('DOMContentLoaded', function() {
    displayUsers(); 
    
});

function cancelEditUser() {
    const editUserModal = document.getElementById('editModal');
    editUserModal.style.display = 'none';
    
}

function displayUsers() {
    const tableBody = document.querySelector('#customerTable tbody');
    tableBody.innerHTML = '';

    users.forEach((user, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${user.name}</td>
            <td>${user.email}</td>
            <td>${user.phone}</td>
            <td>${user.address}</td>
            <td>
                <button onclick="toggleLock(${index})" class="${user.locked ? 'lock-btn locked' : 'lock-btn'}">
                    ${user.locked ? 'Bỏ khoá' : 'Khoá'}
                </button>
                <button class="edit-btn" onclick="editUser(${index})" ${user.locked ? 'style="display:none;"' : ''}>Sửa</button>
                <div class="locked-overlay"></div>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

function toggleLock(index) {
    if (users[index].locked) {
        const unlockConfirmation = confirm("Bạn có muốn bỏ khoá người dùng này không?");
        if (unlockConfirmation) {
            users[index].locked = false;
            displayUsers();
        }
    } else {
        const lockConfirmation = confirm("Bạn có chắc muốn khoá người dùng này không?");
        if (lockConfirmation) {
            users[index].locked = true;
            displayUsers();
        }
    }
}

function editUser(index) {
    const editUserModal = document.getElementById('editModal');
    const editUserForm = document.getElementById('editForm');

    document.getElementById('editName').value = users[index].name;
    document.getElementById('editEmail').value = users[index].email;
    document.getElementById('editPhone').value = users[index].phone;
    document.getElementById('editAddress').value = users[index].address;

    editUserModal.style.display = 'block';

    editUserForm.addEventListener('submit', function(event) {
        event.preventDefault();

        users[index].name = document.getElementById('editName').value;
        users[index].email = document.getElementById('editEmail').value;
        users[index].phone = document.getElementById('editPhone').value;
        users[index].address = document.getElementById('editAddress').value;

        editUserModal.style.display = 'none';
        alert('Thông tin người dùng đã được cập nhật!');
        displayUsers();
        
    });

    const cancelEditButton = document.getElementById('cancelEdit');
    cancelEditButton.addEventListener('click', function(event) {
        event.preventDefault();
        cancelEditUser();
    });

}

function addUser() {
  
    const newName = document.getElementById('addName').value;
    const newEmail = document.getElementById('addEmail').value;
    const newPhone = document.getElementById('addPhone').value;
    const newAddress = document.getElementById('addAddress').value;
    


    const newUser = {
        name: newName,
        email: newEmail,
        phone: newPhone,
        address: newAddress,
        locked: false 
    };

    users.push(newUser); 
    alert("Thêm thành công");
    displayUsers(); 
}


document.addEventListener('DOMContentLoaded', function() {
    displayUsers(); // Display users on page load
    

    const addUserButton = document.querySelector('.add-btn');
    const addUserModal = document.getElementById('addModal');
    const addUserForm = document.getElementById('addForm');
    const cancelAddButton = document.getElementById('cancelAdd');

    addUserButton.addEventListener('click', function() {
        addUserModal.style.display = 'block';
        
    });

    addUserButton.textContent = 'Thêm';
    

    addUserForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const newUser = {
            name: document.getElementById('addName').value,
            email: document.getElementById('addEmail').value,
            phone: document.getElementById('addPhone').value,
            address: document.getElementById('addAddress').value,
            locked: false 
        };

        users.push(newUser); 
        displayUsers(); 
        addUserModal.style.display = 'none'; 
        addUserForm.reset(); 
        
    });

    cancelAddButton.addEventListener('click', function(event) {
        event.preventDefault();
        addUserModal.style.display = 'none'; 
        addUserForm.reset(); 
    });
});


