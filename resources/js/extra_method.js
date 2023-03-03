export const get_extra_info = (
    extra_years,
    expected_competitors,
    order_of_entry
) => {
    const info = [];
    extra_years.forEach((year, index) => {
        if (index == 0) {
            info[year] = {
                sales_months: 3,
                expected_competitors: expected_competitors,
                order_of_entry: order_of_entry,
            };
        } else if (index == extra_years.length - 1) {
            info[year] = {
                sales_months: 9,
                expected_competitors: expected_competitors,
                order_of_entry: order_of_entry,
            };
        } else {
            info[year] = {
                sales_months: 12,
                expected_competitors: expected_competitors,
                order_of_entry: order_of_entry,
            };
        }
    });
    return info;
};
