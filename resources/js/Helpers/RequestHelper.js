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
     * @param errorTask
     * @param expectedCode
     * @returns {Promise<{}>}
     */
    async handleRequest(path, verb, data = {}, errorTask = 'Error', expectedCode = 200) {
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
                text: errorTask,
                type: 'error'
            });
            result.error = true;
        } else {
            result.error = false;
        }

        return result;
    }

    async get(path, errorTask = 'Receiving data error', expectedCode = 200) {
        return await this.handleRequest(path, 'get', {}, errorTask, expectedCode);
    }

    async delete(path, errorTask = 'Deleting error', expectedCode = 200) {
        return await this.handleRequest(path, 'delete', {}, errorTask, expectedCode);
    }

    async post(path, data = {}, errorTask = 'Posting error', expectedCode = 200) {
        return await this.handleRequest(path, 'post', data, errorTask, expectedCode);
    }

    async patch(path, data = {}, errorTask = 'Editing error', expectedCode = 200) {
        return await this.handleRequest(path, 'patch', data, errorTask, expectedCode);
    }

    async put(path, data = {}) {
        return await this.handleRequest(path, 'put', data);
    }
}
