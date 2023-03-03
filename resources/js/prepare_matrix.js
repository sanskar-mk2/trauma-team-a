export const prepare_future = (strengths, years) => {
    const data = [];
    strengths.forEach((strength) => {
        data[strength.name] = [];
        years.forEach((year) => {
            data[strength.name][year] = 0;
        });
    });
    return data;
};
export const prepare = (strengths, years) => {
    const data = [];
    strengths.forEach((strength) => {
        data[strength.name] = [];
        years.forEach((year) => {
            let vol = strength.market_datas.find(
                (market_data) => year == market_data.year
            ).volume;
            data[strength.name][year] = vol;
        });
    });
    return data;
};

export const prepare_selling_price = (
    strengths,
    extra_years_with_launch,
    bwac,
    erosion,
    loes
) => {
    const data = [];
    strengths.forEach((strength) => {
        data[strength.name] = [];
        let loe = 0;
        let price = 0;
        extra_years_with_launch.forEach((year) => {
            if (year == extra_years_with_launch[0]) {
                loe = loes.find((loe) => loe.name == strength.name);
                price = loe * (bwac / 100);
            } else {
                // price = price * (1 + this.erosion / 100);
                price = price + (erosion / 100) * price;
            }
            data[strength.name][year] = price;
        });
    });
    return data;
};

export const prepare_growth_model = (strengths) => {
    const data = [];
    strengths.forEach((strength) => {
        data[strength.name] = 0;
    });
    return data;
};
