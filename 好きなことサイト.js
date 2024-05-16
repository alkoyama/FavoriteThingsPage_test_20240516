// Add event listeners to the thumbnails to change the selected slide
document.querySelectorAll('.thumbnail').forEach((thumbnail, index) => {
    thumbnail.addEventListener('click', () => {
      document.querySelector('.slider').scrollTo({ left: index * window.innerWidth, behavior: 'smooth' });
      updateSelectedPage(index + 1);
    });
  });
  
  // Update the selected page display
  function updateSelectedPage(pageNumber) {
    document.querySelector('.selected-page').textContent = `Selected Page: ${pageNumber}`;
  }
  
  // Update the selected page when the slide changes
  document.querySelector('.slider').addEventListener('scroll', () => {
    const currentPage = Math.round(document.querySelector('.slider').scrollLeft / window.innerWidth) + 1;
    updateSelectedPage(currentPage);
  });


  



  var path = document.querySelector('.squiggle-animated path');
  var length = path.getTotalLength();
  // Clear any previous transition
  path.style.transition = path.style.WebkitTransition = 'none';
  // Set up the starting positions
  path.style.strokeDasharray = length + ' ' + length;
  path.style.strokeDashoffset = length;
  // Trigger a layout so styles are calculated & the browser
  // picks up the starting position before animating
  path.getBoundingClientRect();
  // Define our transition
  path.style.transition = path.style.WebkitTransition =
    'stroke-dashoffset 2s ease-in-out';
  // Go!
  path.style.strokeDashoffset = '0';