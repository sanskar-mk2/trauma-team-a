import dayjs from "dayjs";
import comp_matrix from "./comp_matrix";
import { prepare, prepare_future } from "./prepare_matrix";

export default function growth(strengths, years, extra_years) {
    return {
        matrix: prepare(strengths, years),
        future_matrix: prepare_future(strengths, extra_years),
        calc_perc: function (year, strength) {
            const this_year = dayjs(year);
            const prev_year = this_year.subtract(1, "year");

            if (
                years.find((year) => prev_year.year() == dayjs(year).year()) ==
                undefined
            ) {
                return "—";
            } else {
                const this_vol = this.matrix[strength][year];
                const prev_vol =
                    this.matrix[strength][prev_year.format("YYYY-MM-DD")];
                const int_val = parseInt(
                    ((this_vol - prev_vol) / prev_vol) * 100
                );
                if (isNaN(int_val)) {
                    return "0%";
                } else {
                    return int_val + "%";
                }
            }
        },
        calc_vol: function (year, strength) {
            const to_get = dayjs(year);
            let starting = dayjs(extra_years[0]);
            let percent_change = parseInt(
                this.future_matrix[strength][starting.format("YYYY-MM-DD")]
            );
            let last_year_vol = parseInt(
                this.matrix[strength][
                    dayjs(starting).subtract(1, "year").format("YYYY-MM-DD")
                ]
            );
            let this_year_vol =
                last_year_vol + (last_year_vol * percent_change) / 100;
            last_year_vol = this_year_vol;
            while (to_get.year() != starting.year()) {
                starting = starting.add(1, "year");
                percent_change = parseInt(
                    this.future_matrix[strength][starting.format("YYYY-MM-DD")]
                );
                this_year_vol =
                    last_year_vol + (last_year_vol * percent_change) / 100;
                last_year_vol = this_year_vol;
            }
            return this_year_vol;
        },
    };
}

// function show(
//     strengths,
//     years,
//     extra_years,
//     expected_competitors,
//     order_of_entry,
//     launch_date,
//     extra_years_with_launch
// ) {

//     const prepare_growth_model = (strengths) => {
//         const data = [];
//         strengths.forEach((strength) => {
//             data[strength.name] = 0;
//         });
//         return data;
//     };

//     const get_starting_vol = (strength, year, matrix, future_matrix) => {
//         const percent_change = future_matrix[strength][year];
//         const last_year_vol =
//             matrix[strength][
//                 dayjs(year).subtract(1, "year").format("YYYY-MM-DD")
//             ];
//         return last_year_vol + (last_year_vol * percent_change) / 100;
//     };

//     const get_sales = (strength, year) => {
//         const str = strengths.find((m) => m.name == strength);
//         const sls = str["market_datas"].find((m) => m.year == year)["sales"];
//         return sls;
//     };

//     const get_extra_info = () => {
//         const info = [];
//         extra_years.forEach((year, index) => {
//             if (index == 0) {
//                 info[year] = {
//                     sales_months: 3,
//                     expected_competitors: expected_competitors,
//                     order_of_entry: order_of_entry,
//                 };
//             } else if (index == extra_years.length - 1) {
//                 info[year] = {
//                     sales_months: 9,
//                     expected_competitors: expected_competitors,
//                     order_of_entry: order_of_entry,
//                 };
//             } else {
//                 info[year] = {
//                     sales_months: 12,
//                     expected_competitors: expected_competitors,
//                     order_of_entry: order_of_entry,
//                 };
//             }
//         });
//         return info;
//     };

//     const prepare_selling_price = (
//         strengths,
//         extra_years_with_launch,
//         bwac,
//         erosion,
//         loes
//     ) => {
//         const data = [];
//         strengths.forEach((strength) => {
//             data[strength.name] = [];
//             let loe = 0;
//             let price = 0;
//             extra_years_with_launch.forEach((year) => {
//                 if (year == extra_years_with_launch[0]) {
//                     loe = loes.find((loe) => loe.name == strength.name);
//                     price = loe * (bwac / 100);
//                 } else {
//                     // price = price * (1 + this.erosion / 100);
//                     price = price + (erosion / 100) * price;
//                 }
//                 data[strength.name][year] = price;
//             });
//         });
//         return data;
//     };

//     return {

//         extra_info: get_extra_info(),
//         get_market_share: function (year) {
//             const comp = this.extra_info[year].expected_competitors;
//             const order = this.extra_info[year].order_of_entry;

//             const players = comp_matrix.find((m) => m.no_of_players == comp);

//             if (players == undefined) {
//                 return 0;
//             }

//             const share = players.share_order_of_entry[order];

//             if (share == undefined) {
//                 return 0;
//             } else {
//                 return share;
//             }
//         },
//         get_effective_market_share: function (year) {
//             const ms = this.get_market_share(year);
//             const sales_months = this.extra_info[year].sales_months;
//             return ms * (sales_months / 12);
//         },
//         get_market_size: function (strength, year) {
//             const ems = this.get_effective_market_share(year) / 100;
//             const vol = this.calc_vol(year, strength);
//             return (ems * vol).toFixed(0);
//         },
//         get_current: function (strength) {
//             const year = years[years.length - 1];
//             const vol = this.matrix[strength][year];
//             const sales = get_sales(strength, year);
//             return (sales / vol).toFixed(2);
//         },
//         growth: prepare_growth_model(strengths),
//         loes: strengths.map((strength) => {
//             let g = this.growth[strength];
//             let launch_year = dayjs(launch_date);
//             let year_till_launch =
//                 extra_years.findIndex(
//                     (year) => dayjs(year).year() == launch_year.year()
//                 ) + 1;
//             let loe =
//                 this.get_current(strength) * (1 + g / 100) ** year_till_launch;

//             return {
//                 loe: loe.toFixed(2),
//                 name: strength.name,
//             };
//         }),
//         erosion: -5,
//         bwac: comp_matrix.find((m) => m.no_of_players == expected_competitors)
//             .bwac,
//         selling_price: prepare_selling_price(
//             strengths,
//             extra_years_with_launch,
//             this.bwac,
//             this.erosion,
//             this.loes
//         ),
//     };
// }
