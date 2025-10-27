document.addEventListener('DOMContentLoaded', function() {

  let ratings = {};

  // Star click
  document.querySelectorAll('.imcr-stars').forEach(starContainer => {
    starContainer.addEventListener('click', function(e) {
      if (e.target.tagName !== 'SPAN') return;

      let field = this.closest('.imcr-criteria').dataset.field;
      let value = parseInt(e.target.dataset.value);
      ratings[field] = value;

      // Highlight stars
      this.querySelectorAll('span').forEach(star => {
        star.classList.toggle('selected', parseInt(star.dataset.value) <= value);
      });
    });
  });

  // Submit
  document.getElementById('imcr-submit').addEventListener('click', function() {
    let review = document.querySelector('#imcr-rating-box textarea').value;

    // Example output (replace with AJAX)
    console.log('Ratings:', ratings);
    console.log('Review:', review);

    document.getElementById('imcr-response').innerText = 'Rating submitted (example).';
  });

});
