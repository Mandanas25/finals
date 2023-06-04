const header = document.querySelector("header");

window.addEventListener ("scroll", function(){
    header.classList.toogle("sticky", this.window.scrollY > 0);
})