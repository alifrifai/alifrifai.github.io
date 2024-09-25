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

document.getElementById("confirm").addEventListener("click", function () {
  swal(
    {
      title: "Penawaran VIP",
      text: "Dapatkan akses VIP dan nikmati nonton tanpa iklan!",
      type: "info",
      showCancelButton: true,
      confirmButtonColor: "#de9e31",
      cancelButtonColor: "#ad0e0e",
      confirmButtonText: "Beli Sekarang",
      cancelButtonText: "Nanti Saja",
    },
    function (isConfirm) {
      if (isConfirm) {
        swal("Terima kasih!", "Anda sekarang VIP!", "success");
      } else {
        swal(
          "Penawaran dibatalkan",
          "Anda dapat mencoba lagi kapan saja.",
          "error"
        );
      }
    }
  );
});

function checkVisibility() {
    const animeCards = document.querySelectorAll('.anime'); // Select all anime cards
    const windowHeight = window.innerHeight;

    animeCards.forEach((animeCard) => {
        const img = animeCard.querySelector('img'); // Get the image inside the anime card
        const text = animeCard.querySelector('.text'); // Get the text overlay inside the anime card

        const cardTop = animeCard.getBoundingClientRect().top;
        const cardBottom = animeCard.getBoundingClientRect().bottom;

        // Check if the card is in the viewport
        if (cardTop < windowHeight && cardBottom > 0) {
            img.classList.add('visible');
            img.classList.remove('hidden-up', 'hidden-down');
            text.classList.add('visible');
            text.classList.remove('hidden-up', 'hidden-down');
        } else if (cardTop > windowHeight) {
            img.classList.remove('visible');
            img.classList.add('hidden-down');
            text.classList.remove('visible');
            text.classList.add('hidden-down');
        } else if (cardBottom < 0) {
            img.classList.remove('visible');
            img.classList.add('hidden-up');
            text.classList.remove('visible');
            text.classList.add('hidden-up');
        }
    });
}
