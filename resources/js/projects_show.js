import dayjs from "dayjs";
import comp_matrix from "./comp_matrix";
import {
    prepare,
    prepare_future,
    prepare_growth_model,
} from "./prepare_matrix";
import { get_extra_info, get_sales } from "./extra_method";

export default function growth(
    strengths,
    years,
    extra_years,
    expected_competitors,
    order_of_entry
) {

    return {
        erosion: -5,
        matrix: prepare(strengths, years),
        future_matrix: prepare_future(strengths, extra_years),
        bwac: comp_matrix.find((m) => m.no_of_players == expected_competitors)
            .bwac,
        growth: prepare_growth_model(strengths),
        extra_info: get_extra_info(
            extra_years,
            expected_competitors,
            order_of_entry
        ),
        get_market_share: function (year) {
            const comp = this.extra_info[year].expected_competitors;
            const order = this.extra_info[year].order_of_entry;

            const players = comp_matrix.find((m) => m.no_of_players == comp);

            if (players == undefined) {
                return 0;
            }

            const share = players.share_order_of_entry[order];

            if (share == undefined) {
                return 0;
            } else {
                return share;
            }
        },
        get_market_size: function (strength, year) {
            const ems = this.get_effective_market_share(year) / 100;
            const vol = this.calc_vol(year, strength);
            return (ems * vol).toFixed(0);
        },
        get_effective_market_share: function (year) {
            const ms = this.get_market_share(year);
            const sales_months = this.extra_info[year].sales_months;
            return ms * (sales_months / 12);
        },
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
        get_current: function (strength) {
            const year = years[years.length - 1];
            const vol = this.matrix[strength][year];
            const sales = get_sales(strength, year, strengths);
            return (sales / vol).toFixed(2);
        },

        
    };
}
