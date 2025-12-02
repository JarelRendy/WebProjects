document.addEventListener("DOMContentLoaded", function () {
    console.log("Avson Room Grid page loaded.");

    // Alert when a room card is clicked
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('click', () => {
            alert("You clicked on a room card!");
        });
    });
});
