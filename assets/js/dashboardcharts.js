var xScales = new Map();
var yScales = new Map();
var toDestroy = [];
var lastClick = "";
var kkk
async function chartdata(endpoint) {
	return await $.get(sDef + "/charts/" + endpoint, function(data) {
		return data;
	});
}

async function dcharts() {
	data = JSON.parse(await chartdata("getclouds"));
	if (!data.success) {
		dchartsnd();
	} else {
		cdash1(data.clouds);
		data = JSON.parse(await chartdata("getservices"));
		if (!data.success) {
			dchartsnds("cdash2");
		} else {
			cdash2(data.services);
		}
		data = JSON.parse(await chartdata("getresources"));
		if (!data.success) {
			dchartsnds("cdash3");
		} else {
			cdash3(data.resources);
		}
		data = JSON.parse(await chartdata("getresourcesav"));
		if (!data.success) {
			dchartsnds("cdash4");
			dchartsnds("cdash5");
			dchartsnds("cdash6");
		} else {
			cdash4(data.resources);
			test5(data.resources); //cdash5(data.resources);
			cdash6(data.resources);
    }
    $(function() {
      $("rect").on("click", function (e) {
        rselected(e)
      })
  });
	}
}

function rselected(e) {
  let thisop = d3.select(e.currentTarget).style('opacity')
  if (thisop == '0.9') {
    d3.selectAll('rect')
    .style('opacity', '0.8')
  } else {
    d3.selectAll('rect')
    .style('opacity', '0.1')
    let curcloud = d3.select(e.currentTarget).attr('data-cid')
    let curid = d3.select(e.currentTarget).attr('data-id')
    let curres = d3.select(e.currentTarget).attr('data-id')
    d3.selectAll('[data-id='+curid+']').style('opacity', '0.9')
    d3.selectAll('[data-id='+curcloud+']').style('opacity', '0.9')
    if (curcloud != 'AZ') {
      d3.selectAll('[data-rt=vmid]').style('opacity', '0.9')
    }
   
    if (curid == curcloud) {
      d3.selectAll('[data-cid='+curcloud+']').style('opacity', '0.9')
    } else {
      if (curres) {
        if (curres == curid) {
          d3.selectAll('[data-id=AWS]').style('opacity', '0.9')
          d3.selectAll('[data-rt=vm]').style('opacity', '0.9')
        }
      }
      let lservice = d3.select(e.currentTarget).attr('data-srid')
      if (lservice) {
        if (lservice == curid) {
          d3.selectAll('[data-srid='+curid+']').style('opacity', '0.9')
        } else {
          d3.selectAll('[data-id='+lservice+']').style('opacity', '0.9')
        }
      }
    }
  }

}

function parentsize(cont) {
	console.log(cont + $("#" + cont).height());
	return { w: $("#" + cont).width(), h: $("#" + cont).height() - 10 };
}

function calcsvgsize(cont, margin, bars) {
	let ncont = cont;

	if (ncont.w > bars.total) {
		ncont["overflow"] = "hidden";
	} else {
		ncont.w = bars.total + margin.l + margin.r;
		ncont["overflow"] = "auto";
	}
	return ncont;
}

function calcbars(data, psize, pmargin, plus = 0) {
	const minsize = 25,
		maxsize = 50,
		margin = 5;
	const csize =
		(psize.w - pmargin.l - pmargin.r) / (data.length + plus) - margin;

	if (csize < minsize) {
		let fsize = minsize;
		let total = fsize * (data.length + plus);
		return { size: Math.floor(fsize), total: Math.floor(total) };
	} else {
		let fsize = csize > maxsize ? maxsize : csize;
		let total = fsize * (data.length + plus);
		return { size: Math.floor(fsize), total: Math.floor(total) };
	}
}

function cdash1(data) {
	const thisdash = "dash1";
	const margin = { l: 20, r: 20, t: 30, b: 80 };
	const pleft = 60;
	const psize = parentsize(thisdash);
	const barsize = calcbars(data, psize, margin, 1);
	const ssize = calcsvgsize(psize, margin, barsize);

	let xdomain = [];
	data.map(item => {
		xdomain.push(item.name);
	});
	// xdomain.push("1")

	const xScale = d3
		.scaleBand()
		.domain(xdomain)
		.range([0, ssize.w - pleft - margin.r])
		.padding(0.1);

	const yScale = d3
		.scaleLinear()
		.domain([0, 1])
		.range([ssize.h - margin.b, margin.t]);

	let tooltip = d3
		.select("body")
		.append("div")
		.attr("class", "bartooltip");

	const svg = d3
		.select("#" + thisdash)
		.append("svg")
		.attr("id", thisdash + "svg")
		.attr("width", ssize.w)
		.attr("height", ssize.h)
		.style("background-color", "rgba(180, 180, 180, 0.2)")
		.style("border-radius", "5px")
		.append("g")
		.attr("transform", "translate(" + pleft + "," + 0 + ")");

	svg
		.selectAll("rect")
		.data(data)
		.enter()
		.append("rect")
		.attr("x", (d, i) => {
			return xScale(d.name);
		})
		.attr("y", (d, i) => margin.t)
		.attr("width", xScale.bandwidth())
		.attr("height", ssize.h - margin.b - yScale(1))
		.attr("fill", "rgb(83, 163, 66)")
    .attr("class", "bar")
    .attr("data-cid", (d)=>d.code)
    .attr("data-id", (d)=>d.code)
		.on("mousemove", function(d) {
			tooltip
				.style("left", d3.event.pageX + 10 + "px")
				.style("top", d3.event.pageY - 70 + "px")
				.style("display", "inline-block")
				.html(` <div>
        <table>
          <tr><td>Cloud:</td><td>${d.name}</td></tr>
          <tr><td>Availability:</td><td>100%</td></tr>
          <tr><td>Cost:</td><td>400$</td></tr>
        </table>
        </div>
      `);
		})
		.on("mouseout", function(d) {
			tooltip.style("display", "none");
		});

	svg
		.selectAll("text")
		.data(data)
		.enter()
		.append("text")
		.style("text-anchor", "end")
		//.attr("dx", "-.8em")
		//.attr("dy", ".15em")

		.attr("x", (d, i) => {
			return xScale(d.name) + xScale.bandwidth() / 2;
		})
		.attr("y", (d, i) => ssize.h - margin.b + 10)
		.text(d => {
			if (d.name.length < 12) {
				return d.name;
			} else {
				return d.name.substring(0, 10) + "...";
			}
		})
		.style("font-size", "0.8em")
		.attr("fill", "#E2F3DF")
		.attr("transform", d => {
			return (
				"rotate (-45, " +
				(xScale(d.name) + xScale.bandwidth() / 2) +
				", " +
				(ssize.h - margin.b + 10) +
				")"
			);
		});

	d3.select("#" + thisdash + "svg")
		.append("text")
		.text("Clouds")
		.style("text-anchor", "end")
		.attr("x", 30)
		.attr("y", 60)
		.style("font-size", "1.5em")
		.attr("fill", "#E2F3DF")
		.attr("transform", d => {
			return "rotate (-90, 30, 60)";
		});
}

function cdash2(data) {
	const thisdash = "dash2";
	const margin = { l: 20, r: 20, t: 30, b: 80 };
	const pleft = 60;
	const psize = parentsize(thisdash);
	const barsize = calcbars(data, psize, margin, 1);
	const ssize = calcsvgsize(psize, margin, barsize);
	let xdomain = [];
	data.map(item => {
		xdomain.push(item.name);
	});
	//xdomain.push("1")

	const xScale = d3
		.scaleBand()
		.domain(xdomain)
		.range([0, ssize.w - pleft - margin.r])
		.padding(0.1);

	const yScale = d3
		.scaleLinear()
		.domain([0, d3.max(data, d => d.resources)])
		.range([ssize.h - margin.b, margin.t]);

	let tooltip = d3
		.select("body")
		.append("div")
		.attr("class", "bartooltip");
	d3.select("#" + thisdash).style("overflow", ssize.overflow);
	const svg = d3
		.select("#" + thisdash)
		.append("svg")
		.attr("id", thisdash + "svg")
		.attr("width", ssize.w)
		.attr("height", ssize.h)
		.style("background-color", "rgba(180, 180, 180, 0.2)")
		.style("border-radius", "5px")
		.append("g")
		.attr("transform", "translate(" + pleft + "," + 0 + ")");

	svg
		.selectAll("rect")
		.data(data)
		.enter()
		.append("rect")
		.attr("x", (d, i) => {
			return xScale(d.name);
		})
		.attr("y", (d, i) => {
			let tc = d.resources == 0 ? yScale(d.resources) - 1 : yScale(d.resources);
			return tc;
		})
		.attr("width", xScale.bandwidth())
		.attr("height", d => {
			let tc = d.resources == 0 ? 1 : ssize.h - margin.b - yScale(d.resources);

			return tc;
		})
		.attr("fill", "rgb(83, 163, 66)")
    .attr("class", "bar")
    .attr('data-id', (d)=>("id"+d.id_service))
    .attr('data-srid', (d)=>("id"+d.id_service))
		.on("mousemove", function(d) {
			tooltip
				.style("left", d3.event.pageX + 10 + "px")
				.style("top", d3.event.pageY - 70 + "px")
				.style("display", "inline-block")
				.html(` <div>
        <table>
          <tr><td>Service:</td><td>${d.name}</td></tr>
          <tr><td>Resources:</td><td>${d.resources}</td></tr>
          <tr><td>Availability:</td><td>100%</td></tr>
          <tr><td>Cost:</td><td>400$</td></tr>
        </table>
        </div>
      `);
		})
		.on("mouseout", function(d) {
			tooltip.style("display", "none");
		});

	svg
		.selectAll("text")
		.data(data)
		.enter()
		.append("text")
		.style("text-anchor", "end")
		//.attr("dx", "-.8em")
		//.attr("dy", ".15em")

		.attr("x", (d, i) => {
			return xScale(d.name) + xScale.bandwidth() / 2;
		})
		.attr("y", (d, i) => ssize.h - margin.b + 10)
		.text(d => {
			if (d.name.length < 12) {
				return d.name;
			} else {
				return d.name.substring(0, 10) + "...";
			}
		})
		.style("font-size", "0.8em")
		.attr("fill", "#E2F3DF")
		.attr("transform", d => {
			return (
				"rotate (-45, " +
				(xScale(d.name) + xScale.bandwidth() / 2) +
				", " +
				(ssize.h - margin.b + 10) +
				")"
			);
		});

	d3.select("#" + thisdash + "svg")
		.append("text")
		.text("Services")
		.style("text-anchor", "end")
		.attr("x", 30)
		.attr("y", 60)
		.style("font-size", "1.5em")
		.attr("fill", "#E2F3DF")
		.attr("transform", d => {
			return "rotate (-90, 30, 60)";
		});
}

function cdash3(data) {
	const thisdash = "dash3";
	const margin = { l: 20, r: 20, t: 30, b: 80 };
	const pleft = 60;
	const psize = parentsize(thisdash);
	const barsize = calcbars(data, psize, margin, 1);
	const ssize = calcsvgsize(psize, margin, barsize);
	let xdomain = [];
	data.map(item => {
		xdomain.push(item.rtype);
	});
	//xdomain.push("1")

	const xScale = d3
		.scaleBand()
		.domain(xdomain)
		.range([0, ssize.w - pleft - margin.r])
		.padding(0.1);

	const yScale = d3
		.scaleLinear()
		.domain([0, d3.max(data, d => d.rcount)])
		.range([ssize.h - margin.b, margin.t]);

	let tooltip = d3
		.select("body")
		.append("div")
		.attr("class", "bartooltip");
	d3.select("#" + thisdash).style("overflow", ssize.overflow);
	const svg = d3
		.select("#" + thisdash)
		.append("svg")
		.attr("id", thisdash + "svg")
		.attr("width", ssize.w)
		.attr("height", ssize.h)
		.style("background-color", "rgba(180, 180, 180, 0.2)")
		.style("border-radius", "5px")
		.append("g")
		.attr("transform", "translate(" + pleft + "," + 0 + ")");

	svg
		.selectAll("rect")
		.data(data)
		.enter()
		.append("rect")
		.attr("x", (d, i) => {
			return xScale(d.rtype);
		})
		.attr("y", (d, i) => {
			let tc = d.rcount == 0 ? yScale(d.rcount) - 1 : yScale(d.rcount);
			return tc;
		})
		.attr("width", xScale.bandwidth())
		.attr("height", d => {
			let tc = d.rcount == 0 ? 1 : ssize.h - margin.b - yScale(d.rcount);

			return tc;
		})
		.attr("fill", "rgb(83, 163, 66)")
    .attr("class", "bar")
    .attr('data-rt', 'vmid')
    .attr('data-id', 'vmid')
		.on("mousemove", function(d) {
			tooltip
				.style("left", d3.event.pageX + 10 + "px")
				.style("top", d3.event.pageY - 70 + "px")
				.style("display", "inline-block")
				.html(` <div>
        <table>
          <tr><td>Type:</td><td>${d.rtype}</td></tr>
          <tr><td>Resources Count:</td><td>${d.rcount}</td></tr>
          <tr><td>Cost:</td><td>400$</td></tr>
        </table>
        </div>
      `);
		})
		.on("mouseout", function(d) {
			tooltip.style("display", "none");
		});

	svg
		.selectAll("text")
		.data(data)
		.enter()
		.append("text")
		.style("text-anchor", "end")
		//.attr("dx", "-.8em")
		//.attr("dy", ".15em")

		.attr("x", (d, i) => {
			return xScale(d.rtype) + xScale.bandwidth() / 2;
		})
		.attr("y", (d, i) => ssize.h - margin.b + 10)
		.text(d => {
			if (d.rtype.length < 12) {
				return d.rtype;
			} else {
				return d.rtype.substring(0, 10) + "...";
			}
		})
		.style("font-size", "0.8em")
		.attr("fill", "#E2F3DF")
		.attr("transform", d => {
			return (
				"rotate (-45, " +
				(xScale(d.rtype) + xScale.bandwidth() / 2) +
				", " +
				(ssize.h - margin.b + 10) +
				")"
			);
		});

	d3.select("#" + thisdash + "svg")
		.append("text")
		.text("Resources")
		.style("text-anchor", "end")
		.attr("x", 30)
		.attr("y", 60)
		.style("font-size", "1.5em")
		.attr("fill", "#E2F3DF")
		.attr("transform", d => {
			return "rotate (-90, 30, 60)";
		});
}

function cdash4(data) {
	const thisdash = "dash4";
	const margin = { l: 20, r: 20, t: 30, b: 80 };
	const pleft = 60;
	const psize = parentsize(thisdash);
	const barsize = calcbars(data, psize, margin, 1);
	const ssize = calcsvgsize(psize, margin, barsize);
	let xdomain = [];
	data.map(item => {
		xdomain.push(item.name);
	});
	//xdomain.push("1")

	const xScale = d3
		.scaleBand()
		.domain(xdomain)
		.range([0, ssize.w - pleft - margin.r])
		.padding(0.1);

	const yScale = d3
		.scaleLinear()
		.domain([0, 100]) //d3.max(data, d => d.availability)])
		.range([ssize.h - margin.b, margin.t]);

	let tooltip = d3
		.select("body")
		.append("div")
		.attr("class", "bartooltip");
	d3.select("#" + thisdash).style("overflow", ssize.overflow);
	const svg = d3
		.select("#" + thisdash)
		.append("svg")
		.attr("id", thisdash + "svg")
		.attr("width", ssize.w)
		.attr("height", ssize.h)
		.style("background-color", "rgba(180, 180, 180, 0.2)")
		.style("border-radius", "5px")
		.append("g")
		.attr("transform", "translate(" + pleft + "," + 0 + ")");

	svg
		.selectAll("rect")
		.data(data)
		.enter()
		.append("rect")
		.attr("x", (d, i) => {
			return xScale(d.name);
		})
		.attr("y", (d, i) => {
			let tc =
				d.availability == 0
					? yScale(d.availability) - 5
					: yScale(d.availability);
			return tc;
		})
		.attr("width", xScale.bandwidth()) //barsize.size)
		.attr("height", d => {
			let tc =
				d.availability == 0 ? 5 : ssize.h - margin.b - yScale(d.availability);

			return tc;
		})
		.attr("fill", "rgb(83, 163, 66)")
    .attr("class", "bar")
    .attr("data-cid", (d)=>d.cloud)
    .attr("data-id", (d)=>d.id)
    .attr('data-srid', (d)=>("id"+d.service))
    .attr('data-rt', 'vm')
		.on("mousemove", function(d) {
			tooltip
				.style("left", (d3.event.pageX - 50) + "px")
				.style("top", d3.event.pageY - 120 + "px")
				.style("display", "inline-block")
				.html(` <div>
        <table>
          <tr><td>Resource:</td><td>${d.name}</td></tr>
          <tr><td>Availability:</td><td>${d.availability}%</td></tr>
          <tr><td>Cost:</td><td>200$</td></tr>
          <tr><td>Cost Swap:</td><td>200$</td></tr>
        </table>
        </div>
      `);
		})
		.on("mouseout", function(d) {
			tooltip.style("display", "none");
		});

	svg
		.selectAll("text")
		.data(data)
		.enter()
		.append("text")
		.style("text-anchor", "end")
		//.attr("dx", "-.8em")
		//.attr("dy", ".15em")

		.attr("x", (d, i) => {
			return xScale(d.name) + xScale.bandwidth() / 2;
		})
		.attr("y", (d, i) => ssize.h - margin.b + 10)
		.text(d => {
			if (d.name.length < 12) {
				return d.name;
			} else {
				return d.name.substring(0, 10) + "...";
			}
		})
		.style("font-size", "0.8em")
		.attr("fill", "#E2F3DF")
		.attr("transform", d => {
			return (
				"rotate (-45, " +
				(xScale(d.name) + xScale.bandwidth() / 2) +
				", " +
				(ssize.h - margin.b + 10) +
				")"
			);
		});

	d3.select("#" + thisdash + "svg")
		.append("text")
		.text("Availability")
		.style("text-anchor", "end")
		.attr("x", 30)
		.attr("y", 60)
		.style("font-size", "1.5em")
		.attr("fill", "#E2F3DF")
		.attr("transform", d => {
			return "rotate (-90, 30, 60)";
		});
}

function cdash6(data) {
	console.log("d6");
	const thisdash = "dash6";
	const margin = { l: 20, r: 20, t: 30, b: 80 };
	const pleft = 60;
	const psize = parentsize(thisdash);
	const barsize = calcbars(data, psize, margin, 1);
	const ssize = calcsvgsize(psize, margin, barsize);
	let xdomain = [];
	data.map(item => {
		xdomain.push(item.name);
	});
	//xdomain.push("1")

	const xScale = d3
		.scaleBand()
		.domain(xdomain)
		.range([0, ssize.w - pleft - margin.r])
		.padding(0.1);

	const yScale = d3
		.scaleLinear()
		.domain([100, 0])
		.range([ssize.h - margin.b, margin.t]);

	let tooltip = d3
		.select("body")
		.append("div")
		.attr("class", "bartooltip");
	d3.select("#" + thisdash).style("overflow", ssize.overflow);
	const svg = d3
		.select("#" + thisdash)
		.append("svg")
		.attr("id", thisdash + "svg")
		.attr("width", ssize.w)
		.attr("height", ssize.h)
		.style("background-color", "rgba(180, 180, 180, 0.2)")
		.style("border-radius", "5px")
		.append("g")
		.attr("transform", "translate(" + pleft + "," + 0 + ")");

	svg
		.selectAll("rect")
		.data(data)
		.enter()
		.append("rect")
		.attr("x", (d, i) => {
			return xScale(d.name);
		})
		.attr("y", (d, i) => {
			let tc = d.availability == 100 ? yScale(99) : yScale(d.availability);
			return tc;
		})
		.attr("width", xScale.bandwidth()) //barsize.size)
		.attr("height", d => {
			let tc =
				d.availability == 100 ? 1 : ssize.h - margin.b - yScale(d.availability);

			return tc;
		})
		.attr("fill", "rgb(209, 80, 38)")
    .attr("class", "bar")
    .attr("data-cid", (d)=>d.cloud)
    .attr("data-id", (d)=>d.id)
    .attr('data-srid', (d)=>("id"+d.service))
    .attr('data-rt', 'vm')
		.on("mousemove", function(d) {
			tooltip
				.style("left", d3.event.pageX + 10 + "px")
				.style("top", d3.event.pageY - 70 + "px")
				.style("display", "inline-block")
				.html(` <div>
        <table>
          <tr><td>Resource:</td><td>${d.name}</td></tr>
          <tr><td>Downtime:</td><td>25</td></tr>
          <tr><td>Availability:</td><td>90%</td></tr>
          <tr><td>Cost:</td><td>200$</td></tr>
          <tr><td>Cost Swap:</td><td>200$</td></tr>
        </table>
        </div>
      `);
		})
		.on("mouseout", function(d) {
			tooltip.style("display", "none");
		});

	svg
		.selectAll("text")
		.data(data)
		.enter()
		.append("text")
		.style("text-anchor", "end")
		//.attr("dx", "-.8em")
		//.attr("dy", ".15em")

		.attr("x", (d, i) => {
			return xScale(d.name) + xScale.bandwidth() / 2;
		})
		.attr("y", (d, i) => ssize.h - margin.b + 10)
		.text(d => {
			if (d.name.length < 12) {
				return d.name;
			} else {
				return d.name.substring(0, 10) + "...";
			}
		})
		.style("font-size", "0.8em")
		.attr("fill", "#E2F3DF")
		.attr("transform", d => {
			return (
				"rotate (-45, " +
				(xScale(d.name) + xScale.bandwidth() / 2) +
				", " +
				(ssize.h - margin.b + 10) +
				")"
			);
		});

	d3.select("#" + thisdash + "svg")
		.append("text")
		.text("Downtime")
		.style("text-anchor", "end")
		.attr("x", 30)
		.attr("y", 60)
		.style("font-size", "1.5em")
		.attr("fill", "#E2F3DF")
		.attr("transform", d => {
			return "rotate (-90, 30, 60)";
		});
}

function dchartsnd() {
	$(".dcharts").each(function(i) {
		const svg = d3
			.select("#" + $(this).attr("id"))
			.append("svg")
			.attr("width", $(this).width())
			.attr("height", $(this).height())
			.attr("id", $(this).attr("id") + "svg")
			.append("text")
			.attr("x", 100)
			.attr("y", 100)
			.text("NO data");
	});
}

function dchartsnds(element) {
	const svg = d3
		.select("#" + element)
		.append("svg")
		.attr("width", $("#" + element).width())
		.attr("height", $("#" + element).height())
		.attr("id", $("#" + element).attr("id") + "svg")
		.append("text")
		.attr("x", 100)
		.attr("y", 100)
		.text("NO data");
}

function test5(data) {
  const thisdash = "dash5";
	let margin = { l: 20, r: 20, t: 30, b: 80 };
	const pleft = 60;
	const psize = parentsize(thisdash);
  const ssize = psize;
  const color = d3.scaleOrdinal().range(
    d3.schemeDark2.map(function(c) {
      c = d3.rgb(c);
      //c.opacity = 0.5;
      return c;
    })
  )
  console.log("cur size" + JSON.stringify(ssize))
	 margin = { top: 10, right: 10, bottom: 10, left: 10 },
		width = ssize.w-pleft,
		height = ssize.h ;
    let tooltip = d3
		.select("body")
		.append("div")
		.attr("class", "bartooltip");
	// append the svg object to the body of the page
	  d3.select("#" + thisdash)
    .append("div")
    .attr("id", "bgmain")
    .style("min-height", ssize.h + "px")
    .style("min-width", ssize.w + "px")
    .style("background-color", "rgba(180, 180, 180, 0.2)")
    .style("border-radius", "5px")

    d3.select("#bgmain")
    .append("div")
    .attr("id", "gbleft")
    .style("min-height", (ssize.h -margin.top) + "px")
    .style("width", ((Math.floor(ssize.w*0.3)) - margin.left) + "px")
    //.style("background-color", "rgba(60, 180, 180, 0.2)")
    .style("border-radius", "5px")
    .style("margin-left", margin.left + "px")
    .style("float", "left")
    .style("padding-top", margin.top + "px")

    d3.select("#bgmain")
    .append("div")
    .attr("id", "gbright")
    .style("min-height", (ssize.h -margin.top) + "px")
    .style("width", ((Math.floor(ssize.w*0.7)) - margin.right) + "px")
    //.style("background-color", "rgba(60, 180, 180, 0.2)")
    .style("border-radius", "5px")
    .style("margin-right", margin.right + "px")
    .style("float", "right")
    .style("padding-top", margin.top + "px")

    const svgsize = parentsize("gbright")


    svg = d3.select("#gbright")
    .append("svg")
		.attr("id", thisdash + "svg")
		.attr("width", svgsize.w)
		.attr("height", svgsize.h)
		//.style("background-color", "rgba(180, 180, 180, 0.2)")
		.style("border-radius", "5px")
		.append("g")
		//.attr("transform", "translate(" + pleft + "," + 0 + ")");

    let gdata = { name: "Resources" };
    gdata["children"] = data;
  

    var root = d3.hierarchy(gdata).sum(function(d){ return d.availability})

	// Then d3.treemap computes the position of each element of the hierarchy
	// The coordinates are added to the root object above
	d3
		.treemap()
		.size([svgsize.w, svgsize.h])
		.padding(1)(root);

	console.log(root.leaves());
	// use this information to add rectangles:
	svg
		.selectAll("rect")
		.data(root.leaves())
		.enter()
    .append("rect")
    .attr("class", "gboxr")
		.attr("x", function(d) {
			return d.x0;
		})
		.attr("y", function(d) {
			return d.y0;
		})
		.attr("width", function(d) {
			return d.x1 - d.x0;
		})
		.attr("height", function(d) {
			return d.y1 - d.y0;
    })
    .attr("data-cid", (d)=>d.data.cloud)
    .attr("data-id", (d)=>d.data.id)
    .attr('data-srid', (d)=>("id"+d.data.service))
    .attr('data-rt', 'vm')
		.style("stroke", "black")
		.style("fill", function(d) {
			while (d.depth > 1) d = d.parent;
			return color(d.data.name);
    })
    .on("mousemove", function(d) {
			tooltip
				.style("left", d3.event.pageX + 10 + "px")
				.style("top", d3.event.pageY - 70 + "px")
				.style("display", "inline-block")
				.html(` <div>
        <table>
          <tr><td>Resource:</td><td>${d.data.name}</td></tr>
          <tr><td>Cost:</td><td>200$</td></tr>
          <tr><td>Cost Swap:</td><td>200$</td></tr>
        </table>
        </div>
      `);
		})
		.on("mouseout", function(d) {
			tooltip.style("display", "none");
		});
    

	// and to add the text labels
	svg
		.selectAll("text")
		.data(root.leaves())
		.enter()
		.append("text")
		.attr("x", function(d) {
			return d.x0 + 10;
		}) // +10 to adjust position (more right)
		.attr("y", function(d) {
			return d.y0 + 20;
		}) // +20 to adjust position (lower)
		.text(function(d) {
			return d.data.name;
		})
		.attr("font-size", "0.8em")
    .attr("fill", "white");
    
    svg = d3.select("#gbleft")
    .selectAll("li")
    .data(root.leaves())
    .enter()
    .append("li")
    .attr("class", "bgli")
    .style("color", function(d) {
			while (d.depth > 1) d = d.parent;
			return color(d.data.name);
    })
    .text((d)=>{
      if (d.data.name.length < 12 ){
        return d.data.name
      } else {
        return (d.data.name.substring(0,10) + "...")
      }
    })
}

// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

var resizeTimer, currentDepth;
function cdash5(data) {
	let gdata = { name: "Resources" };
	gdata["children"] = data;
	var width = 100, // % units for CSS responsiveness
		height = 100,
		snap = snap || 0.0001,
		x = d3
			.scaleLinear()
			.domain([0, width])
			.range([0, width]),
		y = d3
			.scaleLinear()
			.domain([0, height])
			.range([0, height]),
		color = d3.scaleOrdinal().range(
			d3.schemeDark2.map(function(c) {
				c = d3.rgb(c);
				//c.opacity = 0.5;
				return c;
			})
		),
		treemap = d3
			.treemap()
			.size([width, height])
			.tile(
				d3.treemapSquarify
				//.ratio(1)
			)
			.paddingInner(0)
			.round(false), //true
		//data = JSON.parse('{"name":"one","children":[{"name":"ompfront","availability":97},{"name":"ec2database","availability":90},{"name":"caasback","availability":95},{"name":"testwithme1","availability":98},{"name":"A-env","availability":100},{"name":"GYMBaseExchange","availability":94,"price":145},{"name":"GymBaseV2RP","availability":98,"price":89},{"name":"GymBasePN","availability":95,"price":126},{"name":"GymBase","availability":100,"price":65}]}'),
		data = gdata;

	nodes = d3.hierarchy(data).sum(function(d) {
		return d.availability ? 1 : 0;
	});

	treemap(nodes);

	var chart = d3.select("#dash5");
	var cells = chart
		.selectAll(".node")
		.data(nodes.descendants())
		.enter()
		.append("div")
		.attr("class", function(d) {
			return "node level-" + d.depth;
		})
		.attr("title", function(d) {
			return d.data.name ? d.data.name : "null";
		});

	cells
		//.style("transform", function(d) { return "translateY(" + chart.node().clientHeight * y(d.y0) / 100 + ")"; })
		.style("left", function(d) {
			//console.log( x(d.x0) + " => " + nearest(x(d.x0), snap) );
			return nearest(x(d.x0), snap) + "%";
		})
		.style("top", function(d) {
			console.log(y(d.y0) + " => " + nearest(y(d.y0), snap));
			return nearest(y(d.y0), snap) + "%";
		})
		.style("width", function(d) {
			return nearest(x(d.x1) - x(d.x0), snap) + "%";
		})
		.style("height", function(d) {
			console.log(
				y(d.y1) - y(d.y0) + " => " + nearest(y(d.y1) - y(d.y0), snap)
			);
			return nearest(y(d.y1) - y(d.y0), snap) + "%";
		})
		//.style("background-image", function(d) { return d.value ? imgUrl + d.value : ""; })
		.style("background-color", function(d) {
			while (d.depth > 1) d = d.parent;
			return color(d.data.name);
		})
		.on("click", zoom);

	cells
		.append("p")
		.attr("class", "label")
		.text(function(d) {
			return d.data.name ? d.data.name : "null";
		});

	var parent = d3
		.select(".logo")
		.datum(nodes)
		.on("click", zoom);

	// can't resquarify as we use 100*100% treemap size. Doh!
	d3.select(window).on("resize", function() {
		clearTimeout(resizeTimer);
		resizeTimer = setTimeout(redraw, 250);
	});

	showPath(nodes.ancestors());
}

// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

function zoom(d) {}

function redraw() {
	console.log("window resized");

	treemap(nodes); //?
	//cells
	//	.datum(nodes)
	//	.call(zoom);
}

function showPath(p) {
	var path = d3
		.select(".breadcrumb")
		.selectAll("a")
		.data(
			p
				.map(function(d) {
					return d;
				})
				.reverse()
		);

	path.exit().remove();

	path
		.enter()
		.append("a")
		.attr("href", "#")
		.html(function(d) {
			return d.data.name;
		})
		.on("click", zoom);
}

function nearest(x, n) {
	return n * Math.round(x / n);
}

$(document).ready(function() {
	if (runDash) {
		dcharts();
	}
});
