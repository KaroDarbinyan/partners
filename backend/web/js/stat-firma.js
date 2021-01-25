am4core.useTheme(am4themes_dark);
am4core.useTheme(am4themes_animated);
// Themes end

var data = {
  "Bjørvika / Gamle Oslo": { "Charlotte Davidsen": 34, "Henrik Jensen": 12, "Marita Friis Stensland": 12, "Mats Ergo": 17, "Robin Rodahl": 22, "Terje Rindal": 31 },
  "Carl Berner": { "Anne Christensen": 2, "Joachim Schala": 34, "Joakim Sveum": 11, "Joakim Torp": 18, "Kjerstin Falkum": 27, "Steffen Usterud": 11, "Torfinn Sørvang": 17, "Truls Martin Nygaard": 8, "Vidar Tangstad": 9 },
  "Grünerløkka": { "Adrian Jensen": 12, "Anders Sveen": 14, "Bård Tisthamar": 12, "Bjørnar Mikkelsen": 31, "Kjerstin Falkum": 3, "Kornelia Krynicka": 6, "Mai Phan": 0, "Steinar Hånes": 11 },
  "Kalbakken": { "Adrianna Bialkowska": 7, "Jannik Holm": 15, "Marius Wang": 19, "Milla Johnsen": 24, "Terje Rindal": 11, "Thor Wæraas": 17 },
  "Oslo Vest": { "Kristine Huse": 19, "Mona Irene Tunsli": 22 },
  "Sagene": { "Andreas Ulfsrud": 21, "Anette Borvik": 14, "Berit Holmeide Vaagland": 30, "Carl Uthus": 8, "Erik Danielsen": 8, "Helene Molle": 11, "Marcus Egeland": 19, "Rebecca M. Madland": 41, "Zehra Catak": 14 },
  "Torshov": { "Erik Bryn Johannessen": 21, "Eskil Næss Hagen": 32, "Huong Pham": 40, "Lene Brekken": 16, "Oscar André Halsen": 19 }
}

function processData(data) {
  var treeData = [];

  var smallBrands = { name: "Other", children: [] };

  for (var brand in data) {
    var brandData = { name: brand, children: [] }
    var brandTotal = 0;
    for (var model in data[brand]) {
      brandTotal += data[brand][model];
    }

    for (var model in data[brand]) {
      // do not add very small
      if (data[brand][model] > 1) {
        brandData.children.push({ name: model, count: data[brand][model] });
      }
    }

    // add to small brands if total number less than
    if (brandTotal > 1) {
      treeData.push(brandData);
    }
    else {
      smallBrands.children.push(brandData)
    }

  }
  treeData.push(smallBrands);
  return treeData;
}

// create chart
var chart = am4core.create("chartdiv", am4charts.TreeMap);
chart.hiddenState.properties.opacity = 0; // this makes initial fade in effect

// only one level visible initially
chart.maxLevels = 1;
// define data fields
chart.dataFields.value = "count";
chart.dataFields.name = "name";
chart.dataFields.children = "children";

// enable navigation
chart.navigationBar = new am4charts.NavigationBar();

// level 0 series template
var level0SeriesTemplate = chart.seriesTemplates.create("0");
level0SeriesTemplate.strokeWidth = 2;

// by default only current level series bullets are visible, but as we need brand bullets to be visible all the time, we modify it's hidden state
level0SeriesTemplate.bulletsContainer.hiddenState.properties.opacity = 1;
level0SeriesTemplate.bulletsContainer.hiddenState.properties.visible = true;
// create hover state
var columnTemplate = level0SeriesTemplate.columns.template;
var hoverState = columnTemplate.states.create("hover");

// darken
hoverState.adapter.add("fill", function (fill, target) {
  if (fill instanceof am4core.Color) {
    return am4core.color(am4core.colors.brighten(fill.rgb, -0.2));
  }
  return fill;
})



// level1 series template
var level1SeriesTemplate = chart.seriesTemplates.create("1");
level1SeriesTemplate.columns.template.fillOpacity = 0;

var bullet1 = level1SeriesTemplate.bullets.push(new am4charts.LabelBullet());
bullet1.locationX = 0.5;
bullet1.locationY = 0.5;
bullet1.label.text = "{name}";
bullet1.label.fill = am4core.color("#ffffff");

// level2 series template
var level2SeriesTemplate = chart.seriesTemplates.create("2");
level2SeriesTemplate.columns.template.fillOpacity = 0;

var bullet2 = level2SeriesTemplate.bullets.push(new am4charts.LabelBullet());
bullet2.locationX = 0.5;
bullet2.locationY = 0.5;
bullet2.label.text = "{name}";
bullet2.label.fill = am4core.color("#ffffff");

chart.data = processData(data);