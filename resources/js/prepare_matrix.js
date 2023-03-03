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
