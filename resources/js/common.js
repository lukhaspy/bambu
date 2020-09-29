import Axios from "axios";

export default {
    methods: {
        async callApi(method, url, data = {}) {
            try {
                return await Axios({
                    method: method,
                    url: url,
                    data: data
                });
            } catch (e) {
                return e.response;
            }
        }
    }
};
