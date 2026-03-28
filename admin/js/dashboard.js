/* Admin dashboard — vanilla JS, no jQuery */

"use strict";

document.addEventListener("DOMContentLoaded", function () {
  /* ── Chart (only runs if the canvas element exists) ────── */
  var canvas = document.getElementById("myChart");
  if (canvas && typeof Chart !== "undefined") {
    new Chart(canvas, {
      type: "line",
      data: {
        labels: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        datasets: [
          {
            data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
            lineTension: 0,
            backgroundColor: "transparent",
            borderColor: "#3b82f6",
            borderWidth: 3,
            pointBackgroundColor: "#3b82f6",
            pointRadius: 4,
          },
        ],
      },
      options: {
        scales: {
          yAxes: [{ ticks: { beginAtZero: false } }],
        },
        legend: { display: false },
      },
    });
  }
});
