// Call Functions When the user scrolls down a defined height from the top of the document
window.onscroll = function() {
  
	modify_header();
	show_or_hide_scroll_button();
	
};


// Add a class to the header upon scroll 
function modify_header() {

	if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
		document.getElementById("navigation").classList.add("scrolled");
	} else {
		document.getElementById("navigation").classList.remove("scrolled");
	}

}


// Scroll to Top Button 
// Get the button:
mybutton = document.getElementById("backToTop");

// Show or Hide the button when user scrolls 20px
function show_or_hide_scroll_button() {

	if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
		mybutton.style.display = "block";
	} else {
		mybutton.style.display = "none";
	}

}

// When the user clicks on the button, scroll to the top of the document
function scroll_to_top() {

	// For Safari
	document.body.scrollTop = 0;
	// For Chrome, Firefox, IE and Opera
	document.documentElement.scrollTop = 0;

}


// Activate Bootstrap Tooltips 
$(function () {
	$('[data-toggle="tooltip"]').tooltip()
})


// Homepage Countdown timer
// Set the date we're counting down to
var countDownDate = new Date("April 26, 2023 08:00:00").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

	// Get today's date and time
	var now = new Date().getTime();

	// Find the difference between now and the count down date
	var difference = countDownDate - now;

	// Time calculations for days, hours, minutes and seconds
	var days = Math.floor(difference / (1000 * 60 * 60 * 24));
	var hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	var minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
	var seconds = Math.floor((difference % (1000 * 60)) / 1000);

	// Display the result in the element with id="demo"
	document.getElementById('countdown').innerHTML = days + ' days, ' + hours + ' hrs<span class="d-lg-none"><br></span><span class="d-none d-lg-inline">,</span> '
	+ minutes + ' mins, ' + seconds + ' secs ';

	// If the count down is finished, write some text
	if (difference < 0) {

		clearInterval(x);
		document.getElementById('countdown').innerHTML = 'EVENT STARTED';

	}

}, 1000);