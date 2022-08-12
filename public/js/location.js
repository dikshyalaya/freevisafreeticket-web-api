const loadStates = (country_id) => {
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
            states = json;
            $("#select-state").empty();
            console.log("state: " + state_id);
            json.forEach((state) => {
                let selection = "";
                 console.log("stater: " + state.id);
                if (state_id == state.id) {
                    selection = "selected";
                }
                $("#select-state").append(
                    `<option value="${state.id}" ${selection}>${state.name}</option>`
                );
            });
            // loadCities($("#select-state").val());
            // loadDistricts($("#select-state").val());
              console.log("state1: " + state_id);
            loadCities(state_id);
            loadDistricts(state_id);
        });
};
const loadCities = async (state_id) => {
    fetch(appurl + "ajax/cities", {
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
            cities = json;
            console.log("city: " + city_id);
            $("#select-city").empty();
            json.forEach((city) => {
                let selection = "";
                if (city_id == city.id) {
                    selection = "selected";
                }
                $("#select-city").append(
                    `<option value="${city.id}" ${selection}>${city.name}</option>`
                );
            });
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

const getDistricts = (state_id) => {
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
            // loadCities($("#select-state").val());
        });
};

const patchStates = (obj) => {
      console.log(obj.val());
    loadStates(obj.value);
};
const patchCities = (obj) => {
     console.log(obj);
    loadCities(obj.value);
};
const patchDistricts = (obj) => {
     console.log(obj);
    loadDistricts(obj.value);
};
const patchGetDistricts = (obj) => {
     console.log(obj);
    getDistricts(obj.value);
};

$(document).ready(function () {
    if (typeof loadtrue == 'undefined') {
        loadStates($("#select-country").val());
    }
});
