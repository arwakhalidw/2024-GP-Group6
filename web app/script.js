$(document).ready(function(){
  // Add smooth scrolling to all links in navbar + footer link
  $(".navbar a, footer a[href='#home']").on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
     

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 900, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
  
  $(window).scroll(function() {
    $(".slideanim").each(function(){
      var pos = $(this).offset().top;

      var winTop = $(window).scrollTop();
        if (pos < winTop + 600) {
          $(this).addClass("slide");
        }
    });
  });
})



//confirm password
document.addEventListener("DOMContentLoaded", function() {
  const passwordInput = document.getElementById('password');
  const confirmPasswordInput = document.getElementById('confirmPassword');
  const passwordMatchMessage = document.getElementById('passwordMatchMessage');
  const registerButton = document.getElementById('registerButton');
  
  function checkPasswords() {
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;

    if (password !== confirmPassword) {
      passwordMatchMessage.style.display = 'inline-block';
    } else {
      passwordMatchMessage.style.display = 'none';
    }
  }
  
  function registerUser() {
    const form = document.getElementById('registrationForm');
    const formData = new FormData(form);

    if (passwordInput.value !== confirmPasswordInput.value) {
      passwordMatchMessage.style.display = 'inline-block';
      return;
    }

    // AJAX request
    fetch(form.action, {
      method: 'POST',
      body: formData
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      // Handle successful registration (data contains response from server)
      console.log(data);
    })
    .catch(error => {
      // Handle error
      console.error('There was a problem with the registration:', error);
    });
  }
  
  passwordInput.addEventListener('input', checkPasswords);
  confirmPasswordInput.addEventListener('input', checkPasswords);
  registerButton.addEventListener('click', registerUser);
});

function validateForm() {
  // Validate email format
  var emailInput = document.getElementById("email");
  var emailError = document.getElementById("emailError");

  var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(emailInput.value)) {
    emailError.style.display = "block"; // Display error message
    return false; // Prevent form submission
  } else {
    emailError.style.display = "none"; // Hide error message
  }

  // Validate radio buttons
  var radios = document.getElementsByName("role");
  var radioChecked = false;
  for (var i = 0; i < radios.length; i++) {
    if (radios[i].checked) {
      radioChecked = true;
      break;
    }
  }
  if (!radioChecked) {
    document.getElementById("roleErrorMessage").style.display = "block";
    return false; // Prevent form submission
  }

  // All validations passed, allow form submission
  return true; 
}
