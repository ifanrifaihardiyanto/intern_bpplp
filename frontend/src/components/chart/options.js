import moment from "moment";

function lineSeriesOption(props) {
  const xAxisOptions = {
    type: "string",
    categories: props.labels,
    tickAmount: 10,
    labels: {
      formatter: (value, timestamp, opts) => {
        return moment(`${value}01`).format("MMM");
      },
    },
  };

  if (props.xaxisFormat != null) {
    xAxisOptions.labels.formatter = props.xaxisFormat.formatter;
  }

  const yAxisOptions = {
    labels: {
      style: {
        colors: "#8e8da4",
      },
      offsetX: 0,
    },
  };

  if (props.yaxisFormat != null) {
    yAxisOptions.formatter = props.yaxisFormat.formatter;
  }

  return {
    title: {
      text: props.title,
      align: "left",
      style: {
        fontSize: "16px",
        color: "#666",
      },
    },
    chart: {
      height: 350,
      type: "line",
    },
    stroke: {
      width: 5,
      curve: "smooth",
    },
    xaxis: props.xaxis ?? xAxisOptions,
    yaxis: props.yaxis ?? yAxisOptions,
    fill: {
      type: "gradient",
      gradient: {
        shade: "dark",
        gradientToColors: ["#FDD835"],
        shadeIntensity: 1,
        type: "horizontal",
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 100, 100, 100],
      },
    },
  };
}

function pieSeriesOption(props) {
  return {
    title: {
      text: props.title,
    },
    chart: {
      width: "100%",
      type: "pie",
    },
    labels: props.labels,
    legend: {
      show: false,
    },
  };
}

function columnSeriesOption(props) {
  let yaxisLabels = {};
  let formatter = null;

  if (
    props.xaxisFormat != undefined &&
    props.xaxisFormat.formatter != undefined
  ) {
    formatter = props.xaxisFormat.formatter;
  }

  if (props.yaxis != undefined) {
    yaxisLabels = props.yaxis.labels;
  }

  return {
    title: {
      text: props.title,
    },
    chart: {
      type: "bar",
      height: 350,
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "55%",
        endingShape: "rounded",
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      show: true,
      width: 2,
      colors: ["transparent"],
    },
    xaxis: {
      categories: props.labels,
      labels: {
        formatter,
      },
    },
    yaxis: {
      labels: {
        ...yaxisLabels,
      },
    },
    fill: {
      opacity: 1,
    },
    // tooltip: {
    //   y: {
    //     formatter: function (val) {
    //       return "$ " + val + " thousands";
    //     },
    //   },
    // },
  };
}

function radialBarSeriesOptions(props) {
  return {
    chart: {
      height: 350,
      type: "radialBar",
      toolbar: {
        show: false,
      },
    },
    plotOptions: {
      radialBar: {
        startAngle: -135,
        endAngle: 225,
        hollow: {
          margin: 0,
          size: "50%",
          background: "#fff",
          imageOffsetX: 0,
          imageOffsetY: 0,
          position: "front",
          dropShadow: {
            enabled: true,
            top: 0,
            left: 0,
            blur: 4,
            opacity: 0.1,
          },
        },
        track: {
          background: "#fff",
          strokeWidth: "67%",
          margin: 0, // margin is in pixels
          dropShadow: {
            enabled: true,
            top: -3,
            left: 0,
            blur: 4,
            opacity: 0.35,
          },
        },
        dataLabels: {
          show: true,
          name: {
            offsetY: -20,
            show: true,
            color: "#888",
            fontSize: "13px",
          },
          value: {
            formatter: function (val) {
              return parseInt(val);
            },
            offsetY: 0,
            color: "#111",
            fontSize: "30px",
            show: true,
          },
        },
      },
    },
    fill: {
      type: "gradient",
      gradient: {
        shade: "dark",
        type: "horizontal",
        shadeIntensity: 0.5,
        gradientToColors: ["#ABE5A1"],
        inverseColors: true,
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 100],
      },
    },
    stroke: {
      lineCap: "round",
    },
    labels: ["Percent"],
  };
}

const TypeOption = {
  LINE: "line",
  COLUMN: "bar",
  PIE: "pie",
  RADIAL_BAR: "radialBar",
};

function getOption(type, props) {
  switch (type) {
    case TypeOption.LINE:
      return lineSeriesOption(props);
      break;
    case TypeOption.COLUMN:
      return columnSeriesOption(props);
      break;
    case TypeOption.PIE:
      return pieSeriesOption(props);
      break;
    case TypeOption.RADIAL_BAR:
      return radialBarSeriesOptions(props);
      break;
    default:
      return lineSeriesOption(props);
      break;
  }
}

export {
  TypeOption,
  getOption,
  lineSeriesOption,
  columnSeriesOption,
  pieSeriesOption,
  radialBarSeriesOptions,
};
