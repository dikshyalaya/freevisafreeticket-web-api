const loadStates = (country_id) => {
    console.log(country_id);
    fetch(appurl + "ajax/states", {
        method: "POST",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            _token: _token,
            country_id: country_id,
        }),
    })
        .then((res) => res.json())
        .then((json) => {
            // console.log(json);
            states = json;
            $("#states").empty();
            json.forEach((state) => {
                // console.log(state);
                let selection = "";
                if (state_id == state.id) {
                    selection = "selected";
                }
                $("#states").append(
                    `<option value="${state.id}" ${selection}>${state.name}</option>`
                );
            });
            loadDistricts($("#states").val());
        });
};
const loadDistricts = async (state_id) => {
    fetch(appurl + "ajax/districts", {
        method: "POST",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            _token: _token,
            state_id: state_id,
        }),
    })
        .then((res) => res.json())
        .then((json) => {
            districts = json;
            $("#districts").empty();
            json.forEach((district) => {
                let selection = "";
                if (district_id == district.id) {
                    selection = "selected";
                }
                $("#districts").append(
                    `<option value="${district.id}" ${selection}>${district.name}</option>`
                );
            });
        });
};


const patchStates = (obj) => {
    loadStates(obj.value);
};
const patchDistricts = (obj) => {
    loadDistricts(obj.value);
}
$(document).ready(function () {
    console.log($("#select-country").val());
    loadStates($("#select-country").val());
});
