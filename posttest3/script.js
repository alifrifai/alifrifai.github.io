const animeLists = document.querySelectorAll(".list-anime");

animeLists.forEach((list) => {
  list.addEventListener("mousemove", (e) => {
    const listAnimeWidth = list.scrollWidth - list.clientWidth;
    const mouseX = e.clientX - list.getBoundingClientRect().left;
    const scrollX = (mouseX / list.clientWidth) * listAnimeWidth;
    list.scrollTo({
      left: scrollX,
      behavior: "smooth",
    });
  });
});

const toggleButton = document.getElementById("mode-toggle");
const body = document.body;

toggleButton.addEventListener("click", () => {
  body.classList.toggle("dark-mode");
  toggleButton.classList.toggle("dark-mode");
  toggleButton.textContent = body.classList.contains("dark-mode") ? "☀️" : "🌙";

  document.querySelectorAll(".navbar .menu a").forEach((link) => {
    link.classList.toggle("dark-mode");
  });
  document
    .querySelector(".navbar .search-bar input")
    .classList.toggle("dark-mode");

  document.querySelectorAll(".anime").forEach((animeCard) => {
    animeCard.classList.toggle("dark-mode");
  });
});

document.getElementById("confirm").addEventListener("click", function() {
  alert("Penawaran VIP sedang dalam proses. Terima kasih telah menjadi member!");
});
