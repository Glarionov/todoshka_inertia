import axios from "axios";
import { useNotification } from "@kyvg/vue3-notification";

const { notify}  = useNotification()

export default class RequestHelper {
    getBaseUrl() {
        return '';
    }

    /**
     * Performs a request, using base URL
     *
     * @param path
     * @param verb
     * @param data
     * @param errorMessage
     * @param expectedCode
     * @returns {Promise<{}>}
     */
    async handleRequest(path, verb, data = {}, errorMessage = 'Error', expectedCode = 200) {
        let params = [this.getBaseUrl() + path];
        if (['post', 'patch', 'put'].includes(verb)) {
            params.push(data);
        }
        let result = {};

        try {
            result = await axios[verb](...params)
                .then(function (response) {
                    return response;
                })
                .catch(function (response) {
                    return response;
                });
        } catch (e) {

        }
        if (!result || result.status !== expectedCode) {
            notify({
                title: "Request error",
                text: errorMessage,
                type: 'error'
            });
            result.error = true;
        } else {
            result.error = false;
        }

        return result;
    }

    async get(path, errorMessage = 'Receiving data error', expectedCode = 200) {
        return await this.handleRequest(path, 'get', {}, errorMessage, expectedCode);
    }

    async delete(path, errorMessage = 'Deleting error', expectedCode = 200) {
        return await this.handleRequest(path, 'delete', {}, errorMessage, expectedCode);
    }

    async post(path, data = {}, errorMessage = 'Posting error', expectedCode = 200) {
        return await this.handleRequest(path, 'post', data, errorMessage, expectedCode);
    }

    async patch(path, data = {}, errorMessage = 'Editing error', expectedCode = 200) {
        return await this.handleRequest(path, 'patch', data, errorMessage, expectedCode);
    }

    async put(path, data = {}) {
        return await this.handleRequest(path, 'put', data);
    }
}
