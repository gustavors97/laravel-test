const Plugin = {
    install (Vue, options = {}) {
        if (this.installed) {
            return
        }

        this.installed = true;

        Vue.parseJSON = function(jsonString) {
            if (jsonString) {
                try {
                    jsonString = jsonString.replace(/&quot;/g,'"');
                    jsonString = JSON.parse(jsonString);

                    if (jsonString && typeof jsonString === "object") {
                        return Object.values(jsonString);
                    }

                } catch (e) {
                    console.error('helpers.js - Exception on method parseJSON()', e);
                }
            }

            return false;
        }
    }
}

export default Plugin