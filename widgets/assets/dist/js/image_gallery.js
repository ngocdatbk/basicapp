var gallery_wrapper = document.querySelector('.gallery-wrapper');
var gallery = document.querySelector('.gallery');
var galleryItems = document.querySelectorAll('.gallery-item');
var numOfItems = gallery.children.length;
var itemLeft = 0;
var curentItem = 0;


var featured = document.querySelector('.featured-item');
var preview = document.querySelector('.preview-image');

var leftBtn = document.querySelector('.move-btn.left');
var rightBtn = document.querySelector('.move-btn.right');

$(document).ready(function () {
    leftBtn.addEventListener('click', moveLeft);
    rightBtn.addEventListener('click', moveRight);

    for (var i = 0; i < galleryItems.length; i++) {
        galleryItems[i].addEventListener('click', selectItem);
        if (galleryItems[i].classList.contains('active'))
        {
            curentItem = i;
            featured.style.backgroundImage = galleryItems[curentItem].style.backgroundImage;
            preview.style.backgroundImage = galleryItems[curentItem].style.backgroundImage;
        }
    }

    leftBtn.disabled = true;
    leftBtn.classList.add('disabled');
    if(gallery.scrollWidth <= gallery_wrapper.offsetWidth)
    {
        rightBtn.disabled = true;
        rightBtn.classList.add('disabled');
    }

    galleryItems_width = numOfItems * (galleryItems[0].offsetWidth + 4) -4;
    if(galleryItems_width < gallery.offsetWidth)
    {
        gallery.style.left = (gallery_wrapper.offsetWidth - galleryItems_width)/2 + "px";
    }
});


function selectItem(e) {
    if (e.target.classList.contains('active')) return;

    curentItem = Number(e.target.getAttribute("index"));
    changeItem(curentItem);
}

function changeItem(newIndex){
    featured.style.backgroundImage = galleryItems[curentItem].style.backgroundImage;
    preview.style.backgroundImage = galleryItems[curentItem].style.backgroundImage;

    for (var i = 0; i < galleryItems.length; i++) {
        if (galleryItems[i].classList.contains('active'))
            galleryItems[i].classList.remove('active');
    }

    galleryItems[curentItem].classList.add('active');
}

function moveLeft() {
    if(curentItem > 0)
        changeItem(--curentItem);

    itemLeft--;
    gallery.style.left = -galleryItems[itemLeft].offsetLeft + "px";
    if(gallery.offsetLeft >= 0)
    {
        leftBtn.disabled = true;
        leftBtn.classList.add('disabled');
    }
    if(gallery.offsetLeft + gallery.scrollWidth > gallery_wrapper.offsetWidth + galleryItems[0].offsetWidth)
    {
        rightBtn.disabled = false;
        rightBtn.classList.remove('disabled');
    }
}

function moveRight() {
    if(curentItem < numOfItems)
        changeItem(++curentItem);

    itemLeft++;
    gallery.style.left = -galleryItems[itemLeft].offsetLeft + "px";
    if(gallery.offsetLeft + gallery.scrollWidth <= gallery_wrapper.offsetWidth + galleryItems[0].offsetWidth)
    {
        rightBtn.disabled = true;
        rightBtn.classList.add('disabled');
    }

    if(gallery.offsetLeft < 0)
    {
        leftBtn.disabled = false;
        leftBtn.classList.remove('disabled');
    }
}