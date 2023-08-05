$(document).ready(function () {
    $('#example').DataTable();
  });
  
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
  
  /* When the user clicks on the button,
  toggle between hiding and showing the dropdown content */
  function myFunction() {
      document.getElementById("myDropdown").classList.toggle("show");
    }
    
    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }
  
  // Get the modal
  var myModal = document.getElementById('myModal')
  var myInput = document.getElementById('myInput')
  
  myModal.addEventListener('shown.bs.modal', function () {
    myInput.focus()
  })
  
  // Get the status, grup, joblist status, agenda, PIC value
  const status = document.getElementById('inputstatus');
  const grup = document.getElementById('inputgrup');
  const joblist = document.getElementById('status');
  const agenda = document.getElementById('inputagenda');
  const pic = document.getElementById('PIC');