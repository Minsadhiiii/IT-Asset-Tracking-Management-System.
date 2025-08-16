document.addEventListener('DOMContentLoaded', () => {

    const warrantyHeading = document.getElementById('warrantyHeading');
    const orderHerading = document.getElementById('orderHeading');
    const warrantyDetails = document.getElementById('warrantyDetails');
    const orderDetails = document.getElementById('orderDetails');

    warrantyHeading.addEventListener('click', () => {
        warrantyDetails.classList.toggle('hidden');
    });


    orderHeading.addEventListener('click', () => {
        orderDetails.classList.toggle('hidden');
    });
});