document.addEventListener("DOMContentLoaded", function () {
  $.get(this.location.origin + "/service-report", function (data) {
    let label = [];
    let nominal = [];
    $.each(data, function (key, item) {
      label.push(item.transaction_date);
      nominal.push(item.service_order_total);
    });

    var ctx = document
      .getElementById("chartjs-dashboard-line")
      .getContext("2d");
    var gradient = ctx.createLinearGradient(0, 0, 0, 225);
    gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
    gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
    // Line chart
    new Chart(document.getElementById("chartjs-dashboard-line"), {
      type: "line",
      data: {
        labels: label,
        datasets: [
          {
            label: "Sales (Rp)",
            fill: true,
            backgroundColor: gradient,
            borderColor: window.theme.primary,
            data: nominal,
          },
        ],
      },
      options: {
        maintainAspectRatio: false,
        legend: {
          display: false,
        },
        tooltips: {
          intersect: false,
        },
        hover: {
          intersect: true,
        },
        plugins: {
          filler: {
            propagate: false,
          },
        },
        scales: {
          xAxes: [
            {
              reverse: true,
              gridLines: {
                color: "rgba(0,0,0,0.0)",
              },
            },
          ],
          yAxes: [
            {
              ticks: {
                stepSize: 100000,
              },
              display: true,
              borderDash: [3, 3],
              gridLines: {
                color: "rgba(0,0,0,0.0)",
              },
            },
          ],
        },
      },
    });
  });
  $.get(this.location.origin + "/profit", function (data) {
    console.log(data);
    new Chart(document.getElementById("chartjs-dashboard-pie"), {
      type: "pie",
      data: {
        labels: ["Service", "Pickup", "Cost"],
        datasets: [
          {
            data: [data.income, data.pickup_fee, data.cost],
            backgroundColor: [
              window.theme.primary,
              window.theme.warning,
              window.theme.danger,
            ],
            borderWidth: 0,
          },
        ],
      },
      options: {
        responsive: !window.MSInputMethodContext,
        maintainAspectRatio: false,
        legend: {
          display: true,
        },
        cutoutPercentage: 60,
      },
    });
  });
});
