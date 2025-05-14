const cards = document.querySelectorAll(".question-card");
const nextButtons = document.querySelectorAll(".next-button");
const prevButtons = document.querySelectorAll(".prev-button");
const jumpButtons = document.querySelectorAll(".jump-btn");
const radios = document.querySelectorAll('input[type="radio"]');
const modal = document.getElementById("modal");
const closeModalButton = document.getElementById("closeModal");
const unansweredElement = document.getElementById("unanswered");
let currentIndex = 0;

function setCookie(name, value, minutes) {
    const expires = new Date(Date.now() + minutes * 60 * 1000).toUTCString();
    document.cookie = name + "=" + encodeURIComponent(value) + "; expires=" + expires + "; path=/";
}

function getCookie(name) {
    const cookies = document.cookie.split("; ");
    for (let c of cookies) {
        const [k, v] = c.split("=");
        if (k === name) return decodeURIComponent(v);
    }
    return null;
}


function showCard(index) {
    cards.forEach((card) => card.classList.remove("active"));
    cards[index].classList.add("active");

    jumpButtons.forEach((btn, i) => {
        btn.classList.remove("active");
        if (i === index) {
            btn.classList.add("active");
        }
    });

    currentIndex = index;
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
}

function markAnswered(questionIndex) {
    const btn = document.querySelector(
        `.jump-btn[data-index='${questionIndex}']`
    );
    if (btn && !btn.classList.contains("answered")) {
        btn.classList.add("answered");
    }
}

nextButtons.forEach((btn, idx) => {
    btn.addEventListener("click", () => showCard(idx + 1));
});

prevButtons.forEach((btn, idx) => {
    btn.addEventListener("click", () => showCard(idx));
});

jumpButtons.forEach((btn) => {
    btn.addEventListener("click", () =>
        showCard(parseInt(btn.getAttribute("data-index")))
    );
});

// Save to cookies when user selects an answer
radios.forEach((radio) => {
    radio.addEventListener("change", () => {
        const parentCard = radio.closest(".question-card");
        const index = parseInt(parentCard.id.split("-")[1]);
        const questionId = radio.name
            .replace("responses[", "")
            .replace("]", "");
        const selectedOption = radio.value;

        markAnswered(index);

        // Get the current responses from cookies, if any
        let currentResponses = JSON.parse(getCookie("temp_responses") || "{}");
        currentResponses[questionId] = selectedOption;

        // Save updated responses to cookies
        setCookie("temp_responses", JSON.stringify(currentResponses), 60); // 60 menit
    });
});
const form = document.getElementById("questionnaireForm");
form.addEventListener("submit", function (event) {
    const unansweredQuestions = [];
    cards.forEach((card, index) => {
        const radios = card.querySelectorAll('input[type="radio"]');
        const isAnswered = Array.from(radios).some((r) => r.checked);
        if (!isAnswered) {
            unansweredQuestions.push(index + 1);
        }
    });

    if (unansweredQuestions.length > 0) {
        event.preventDefault();
        unansweredElement.textContent =
            "Nomor soal yang belum dijawab: " + unansweredQuestions.join(", ");
        modal.style.display = "flex";
    }
});

closeModalButton.addEventListener("click", () => {
    modal.style.display = "none";
});

showCard(0);

window.addEventListener("DOMContentLoaded", () => {
    const saved = getCookie("temp_responses");
    if (saved) {
        const responses = JSON.parse(saved);
        Object.entries(responses).forEach(([questionId, optionId]) => {
            const radio = document.querySelector(
                `input[name="responses[${questionId}]"][value="${optionId}"]`
            );
            if (radio) {
                radio.checked = true;
                const parentCard = radio.closest(".question-card");
                const index = parseInt(parentCard.id.split("-")[1]);
                markAnswered(index);
            }
        });
    }
});
