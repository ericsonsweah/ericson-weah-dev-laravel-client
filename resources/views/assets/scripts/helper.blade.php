<script>
'use strict'
class Helper {
    constructor() {
            // auto bind methods
        this.autobind(Helper)
        // Broadcasting channesl for communication between pages or navigation contexts
        this.addCartChannel = new BroadcastChannel('cart_add_channel')

    }

    /**
     * @name autobinder
     * @function
     *
     * @param {Object|Function|Class} className the class whose methods to be bound to it
     * 
     * @description auto sets and auto binds every and all methods for the corresponding class (except the constructor)
     * @return does not return anything
     * 
     */

    autobinder(className = {}) {
            for (let method of Object.getOwnPropertyNames(className.prototype)) {
                if (typeof(this[method]) === 'function' && method !== 'constructor') {
                    this[method] = this[method].bind(this)
                }
            }
        }
        /**
         * @name autobind
         * @function
         *
         * @param {Object|Function|Class} className the class whose methods to be bound to it
         * 
         * @description auto mounts and auto binds every and all methods for the corresponding class including itself(it self mounts and self binds)
         * @return does not return anything
         * 
         */
    autobind(className = {}) {
        this.autobinder = this.autobinder.bind(this)
        this.autobinder(className)
    }

    /**
     * @name promisify
     * @function
     *
     * @param {Function|Object} fn the function or object to be promisified
     *  
     * @description promisified functions or objects
     * @return {Function|Object} fn, the promisified function
     * 
     */
    promisify(fn) {
        return (...args) => new Promise((resolve, reject) => fn(...args), (err, data) => (err ? reject(err) : resolve(data)))
    }


    /**
     * @name getField
     * @function
     *
     * @param {String|Object} attribute the attribute to extract
     *  
     * @description Receive the name of an attribute  and produce a new function that will be able to extract  an attribute from an object
     * 
     * @return {Function|Object} object, the function that will be able to extract an attribute from an object
     * 
     */
    getField(attribute) {
        return object => object[attribute]
    }

    /**
     * @name pluckOff
     * @function
     *
     * @param {Function|Object} fn  the function to bind to object method
     *  
     * @description plucks off a method from ANY object and makes that method a completely independent standalone reusable  function.
     * 
     *  For instance, if I wanted to make Array.prototype.map method an independent standalone reusable function, I would do something like this: const myArrayMap = pluckOff(Array.prototype.map). Then I would use it like this:
     * 
     * const array = [1,2,3,4,5]; const result = myArrayMap(array, x => x * 2); result = [2,4,6,8,10]
     * 
     * @return {Function|Object} fn.bind(...args)(), the completely independent standalone reusable function
     * 
     */

    pluckOff(fn) {
        return (...args) => fn.bind(...args)()
    }

    /**
    * @name callOnlyNTimes
    * @function
    *
    * @param {Function|Object} f the function to be called only n times

    * @param {Number} n number of time the function f() should be called
    *  
    * @description creates a function that calls and runs the function f() n times and only n times no matter how many times the function is called or used in the loop. It calls f() exactly n times. For instance if n = 1 and the function is called 200 times, it would call or execute f() only once (no more than once). If n = 5 and the function is called 200 times, it would call or execute f() exactly 5 times and no more than 5 times.
    * 
    * @return {Function|Object} a function that calls fn() only n times
    * 
    */
    callOnlyNTimes(fn, n = 1) {
        let done = false
        return (...args) => {
            if (!done) {
                done = true
                for (let i = 0; i < Math.abs(n); i++) {
                    fn(...args)
                }
            }
        }
    }

    /**
     * @name callFirstOnlyNTimes
     * @function
     *
     * @param {Function|Object} f the function to be called only n times
     * @param {Function|Object} g  the function to be called as many times as left after f() is called n times
     * @param {Number} n number of time the function f() should be called
     *  
     * @description creates a function that calls and runs the first argument function f() n times and only n times no matter how many times the function is called or used in the loop. It calls f() exactly n times and the rest of the times it calls g(). For instance if n = 1 and the function is called 200 times, it would call or execute f() only once and g() 199 times. If n = 5 and the function is called 200 times, it would call or execute f() exactly 5 times and g() 195 times.
     * 
     * @return {Function|Object} a function that calls fn() only n times and g() afterward
     * 
     */
    callFirstOnlyNTimes(f = () => {}, g = () => {}, n = 1) {
        let done = false
        return (...args) => {
            if (!done) {
                done = true
                if (typeof n !== 'number' || n % 1 !== 0) {
                    f(...args)
                } else {
                    for (let i = 1; i <= Math.abs(n); i++) {
                        f(...args)
                    }
                }
            } else {
                g(...args)
            }
        }
    }

    /**
     * @name inputsValid
     * @function
     *
     * @param {Function} arr  the array to validate
     * @param {Function} fn  the call back function to validate
     * @param {Number} flat arr flattening depth to validate
     *  
     * @description validates inputs
     * 
     * @return {Boolean} true if inputs are valid and false if inputs are invalid
     * 
     */
    inputsValid(arr = [], fn = () => {}, flat = 1) {
        if (!Array.isArray(arr)) return false
        if (typeof fn !== 'function') return false;
        if (typeof flat !== 'number' || flat < 0 || (flat % 1 !== 0 && flat !== Infinity)) return false;
        return true
    }

    /**
     * @name none
     * @function
     *
     * @param {Array|Object} arr the array to filter
     * @param {Function|Object} fn the predicate
     * @param {Number} flat  the array to filter flattening depth
     *  
     * @description filters an array
     * 
     * @return {Array|Object} array, the filtered array for which the predicate is true
     * 
     */
    none(arr = [], fn = () => false, flat = 0) {
        return this.inputsValid(arr, fn, flat) ? arr.flat(flat).every(v => !fn(v)) : false
    };

    /**
     * @name forEachAsync
     * @function
     *
     * @param {Array|Object} arr the array to filter
     * @param {Function|Object} fn the callback function
     * @param {Number} flat  the array to filter flattening depth
     *  
     * @description asynchronously  loops an array
     * 
     * @return {Promise}  a promise if promise is fulfilled and successfull
     * 
     */
    forEachAsync(arr = [], fn = () => false, flat = 0) {
        if (this.inputsValid(arr, fn, flat)) {
            return arr.flat(flat).reduce((promise, value) => promise.then(() => fn(value)), Promise.resolve());
        } else {
            return undefined
        }

    }

    /**
     * @name mapAsync
     * @function
     *
     * @param {Array|Object} arr the array to loop throug
     * @param {Function|Object} fn the callback function
     * @param {Number} flat  the array to filter flattening depth
     *  
     * @description asynchronously  maps an array
     * 
     * @return {Promise}  a promise if promise is fulfilled and successfull
     * 
     */
    mapAsync(arr = [], fn = () => [], flat = 0) {
        return this.inputsValid(arr, fn, flat) ? Promise.all(arr.flat(flat).map(fn)) : []
    }

    /**
     * @name filterAsync
     * @function
     *
     * @param {Array|Object} arr the array to filter
     * @param {Function|Object} fn the callback function
     * @param {Number} flat  the array to filter flattening depth
     *  
     * @description asynchronously  filters an array
     * 
     * @return {Promise}  a promise if promise is fulfilled and successfull
     * 
     */

    filterAsync(arr = [], fn = () => [], flat = 0) {
        if (this.inputsValid(arr, fn, flat)) {
            return this.mapAsync(fn, flat).then(array => arr.flat(flat).filter((v, i) => Boolean(array[i])));
        } else {
            return []
        }
    }

    /**
     * @name reduceAsync
     * @function
     *
     * @param {Array|Object} arr the array to filter
     * @param {Function|Object} fn the callback function
     * @param {Number} flat  the array to filter flattening depth
     *  
     * @description asynchronously  reduces an array
     * 
     * @return {Promise}  a promise if promise is fulfilled and successfull
     * 
     */

    async reduceAsync(arr = [], fn = () => {}, init, flat = 0) {
            if (this.inputsValid(arr, fn, flat)) {
                return Promise.resolve(init).then(accumulator => this.forEachAsync(arr.flat(flat), async(v, i) => {
                    accumulator = fn(accumulator, v, i)
                }).then(() => accumulator));
            } else {
                return 0
            }
        }
        /**
         * @name filter
         * @function
         *
         * @param {Array|Object} arr the array to filter
         * @param {Function|Object} fn the call back function
         * @param {Number} flat  the array to filter flattening depth
         *  
         * @description filters an array
         * 
         * @return {Array|Object} array, the filtered array
         * 
         */
    filtered(arr = [], fn = () => [], flat = 1) {
        return this.inputsValid(arr, fn, flat) ? arr.flat(flat).filter(x => fn(x)) : []
    }

    /**
     * @name filterItems
     * @function
     * 
     * @param {Array|Object} arr the array to filter
     * @param {String} query any fitlering query
     *  
     * @description asynchronously read a query and filter arrays according to the query
     * 
     * @return {Array}  the query filtered array
     * 
     */
    filterItems(query, arr = []) {
        if (!Array.isArray(arr)) return []
        return arr.filter(el => el.toLowerCase().indexOf(query.toLowerCase()) !== -1);
    }

    /**
     * @name some
     * @function
     *
     * @param {Array} arr the array to filter
     * @param {Function} fn the predicate
     * @param {Number} flat  the array to filter flattening depth
     *  
     * @description filters an array according to the thruthiness of the predicate
     * 
     * @return {Boolean} true if at least one of the array items for which the predicate is true if found. false otherwise
     * 
     */
    some(arr = [], fn = () => false, flat = 0) {
        return this.inputsValid(arr, fn, flat) ? arr.flat(flat).reduce((x, y) => x || fn(y), false) : false
    }

    /**
     * @name every
     * @function
     *
     * @param {Array} arr the array to filter
     * @param {Function} fn the predicate
     * @param {Number} flat  the array to filter flattening depth
     *  
     * @description filters an array according to the thruthiness of the predicate
     * 
     * @return {Boolean} true if each one of the array items for which the predicate is true if found. false otherwise
     * 
     */
    every(arr = [], fn = () => false, flat = 0) {
        if (this.inputsValid(arr, fn, falt)) {
            let result = [];
            arr.flat(flat).reduce((x, y) => (x === false && fn(y) ? result.push(y) : result.pop()), false);
            return result.length === arr.flat(flat).length ? true : false;
        } else {
            return false
        }
    }

    /**
     * @name forEach
     * @function
     *
     * @param {Array} arr the array to filter
     * @param {Function} fn the call back funcction
     * @param {Number} flat  the array to filter flattening depth
     *  
     * @description performs fn() operation for each of the array elements
     * 
     * @return {Function|Object} the resulting object or array or element from the fn() operation 
     * 
     */

    forEach(arr = [], fn = () => false, flat = 0) {
        if (this.inputsValid(arr, fn, flat)) {
            for (let i = 0; i < arr.flat(flat).length; i++) {
                fn(arr.flat(flat)[i]);
            }
        } else {
            return undefined
        }
    };

    /**
     * @name filter
     * @function
     *
     * @param {Array} arr the array to filter
     * @param {Function} fn the call back funcction
     * @param {Number} flat  the array to filter flattening depth
     *  
     * @description filters an array according to the thruthiness of the predicate
     * 
     * @return {Array} the resulting array
     * 
     */

    filter(arr = [], fn = () => false, flat = 0) {
        if (this.inputsValid(arr, fn, flat)) {
            let result = [];
            for (let i = 0; i < this.flat(flat).length; i++) {
                fn(arr.flat(flat)[i]) ? result.push(arr.flat(flat)[i]) : [];
            }
            return result.length > 0 ? result : [];
        } else {
            return []
        }
    };

    /**
     * @name flatten
     * @function
     *
     * @param {Array} arr the array to flatten
     *  
     * @description filten an array to whatsover depth or level it has
     * 
     * @return {Array} the resulting flattened array
     * 
     */

    flatten(arr = []) {
        const result = [];
        arr.forEach(el => (Array.isArray(el) ? result.push(...flatten(el)) : result.push(el)));
        return result;
    };

    /**
     * @name findIndex
     * @function
     *
     * @param {Array} arr the array to filter
     * @param {Function} fn the call back funcction
     * @param {Number} flat  the array to filter flattening depth
     *  
     * @description find the index of an array element
     * 
     * @return {Array} the resulting array element
     * 
     */
    findIndex(arr = [], fn = () => false, flat = 0) {
        if (this.inputsValid(arr, fn, flat)) {
            return arr.flat(flat).reduce((x, y, z) => (x === -1 && fn(y) ? z : x), -1);
        } else {
            return undefined
        }


    };

    /**
     * @name map
     * @function
     *
     * @param {Array} arr the array to filter
     * @param {Function} fn the call back function
     * @param {Number} flat  the array to filter flattening depth
     *  
     * @description maps each element with the resulting operation of the callback function
     * 
     * @return {Array} the resulting array 
     * 
     */
    map(arr = [], fn = () => [], flat = 0) {
        return this.inputsValid(arr, fn, flat) ? arr.flat(flat).reduce((x, y) => x.concat(fn(y)), []) : []
    };

    /**
     * @name find
     * @function
     *
     * @param {Array} arr the array to filter
     * @param {Function} fn the predicate
     * @param {Number} flat  the array to filter flattening depth
     *  
     * @description find the first array element for which the predicate is true
     * 
     * @return {Array} the resulting array element
     * 
     */
    find(arr = [], fn = () => false, flat = 0) {
        if (this.inputsValid(arr, fn, flat)) {
            return arr.flat(flat).reduce((x, y) => (x === undefined && fn(y) ? y : x), undefined);
        } else {
            return undefined
        }
    };

    /**
    * @name billOnceAndOnlyOnce
    * @function
    *
    * @param {Function|Object} bill the function to call for billing

    * @param {Function|Object} dontBill the function to call to avoid billing
    *  
    * @description creates a function that is called and runs only onces no matter how many times the function is called or used in the loop. For instance if the function is called 200 times, it would be called or executed only the first round (no more than once); that is it would 1 time and not run the rest of 199 times.
    * 
    * @return {Function|Object} a function that bills only once not matter what
    * 
    */

    billOnceAndOnlyOnce(bill, dontBill) {
        let timeToBill = bill
        return (...args) => {
            let result = timeToBill(...args)
            timeToBill = dontBill
            return result
        }
    }



    /**
     * @name broadcast
     * @function
     *
     * @param {String} channel the broadcasting channel
     * 
     * @description creates a new broadcasting channel
     * 
     * @return {Object} the broadcasting object
     * 
     */
    broadcast(channel) {
        return new BroadcastChannel(channel)
    }

    /**
     * @name receive
     * @function
     *
     * @param {String} channel the broadcasting channel
     * 
     * @description receives a new broadcasting channel message
     * 
     * @return {Object} the event data object
     * 
     */
    receive(channel) {
        this.broadcast(channel).onmessage = event => {
            return event.data
        }
    }

    /**
     * @name send
     * @function
     *
     * @param {Object} message the broadcasting channel message
     * @param {String} channel the broadcasting channel
     * 
     * @description post messages to broadcasting channel
     * 
     * @return {Object} the broadcasting object
     * 
     */
    send(message, channel) {
        this.broadcast(channel).postMessage(message)
    }

    /**
     * @name events
     * @function
     *
     * @param {String} name name of the custom event 
     * @param {Object} detail detail options or data of the custom event
     * @param {Object} options options for the custom event
     * 
     * @description  create a new custom event
     * 
     * @return {Event} the new custom event
     * 
     */
    events(name, detail = {}, options = {
        bubbles: true,
        composed: true,
        detail: detail
    }) {
        return new CustomEvent(name, options)
    }

    /**
     * @name isNotEmpty
     * @function
     *
     * 
     * @description checks to see if window.localStorage is empty
     * 
     * @return {Boolen} true if it is empty; false otherwise
     * 
     */
    isNotEmpty() {
        return !!(localStorage.length > 0)
    }

    /**
     * @name isPresent
     * @function
     *
     * @param {String} localObject string representing the same of the local storage object/item
     * 
     * @description checks for the presence of an item in local storage
     * 
     * @return {Boolean} true if the object is found; false otherwise
     * 
     */
    isPresent(localObject) {
        return !!(window.localStorage.getItem(localObject) !== null)
    }

    /**
     * @name getLocalData
     * @function
     *
     * @param {String} data string representing the same of the local storage object/item
     * 
     * @description gets item from local storage
     * 
     * @return {String|Object} the local storage item 
     * 
     */
    getLocalData(data) {
        return JSON.parse(window.localStorage.getItem(data))
    }

    /**
     * @name callFirstOnlyNTimes
     * @function
     *
     * @param {Function|Object} f the function to be called only n times
     * @param {Function|Object} g  the function to be called as many times as left after f() is called n times
     * @param {Number} n number of time the function f() should be called
     *  
     * @description creates a function that calls and runs the first argument function f() n times and only n times no matter how many times the function is called or used in the loop. It calls f() exactly n times and the rest of the times it calls g(). For instance if n = 1 and the function is called 200 times, it would call or execute f() only once and g() 199 times. If n = 5 and the function is called 200 times, it would call or execute f() exactly 5 times and g() 195 times.
     * 
     * @return {Function|Object} a function that calls fn() only n times and g() afterward
     * 
     */
    callFirstOnlyNTimes(f, g = () => {}, n = 1) {
        let done = false
        return (...args) => {
            if (!done) {
                done = true
                if (typeof n !== 'number' || n % 1 !== 0) {
                    f(...args)
                } else {
                    for (let i = 1; i <= Math.abs(n); i++) {
                        f(...args)
                    }
                }
            } else {
                g(...args)
            }
        }
    }

     /**
     * @name objectCopy
     * @function
     *
     * @param {Object} obj the object whose deep copy to be made
     *  
     * @description makes a deep copy of an object 
     * @return {Object} copy, the copy of the original object
     * 
     */
     objectCopy(obj) {
        const copy = Object.create(Object.getPrototypeOf(obj));
        const propNames = Object.getOwnPropertyNames(obj);
        propNames.forEach(name => {
            const desc = Object.getOwnPropertyDescriptor(obj, name);
            Object.defineProperty(copy, name, desc);
        });
        return copy;
    };

    /**
     * @name isArray
     * @function
     *
     * @param {Object} obj the object to check
     *  
     * @description checks if the object is an array 
     * @return {Boolean} true if the object is an array; false otherwise
     * 
     */

    isArray(obj) {
        try {
            if (Array.isArray(obj)) {
                return true
            } else {
                return false
            }
        } catch (er) {
            return false
        }
    }

     /**
     * @name isArrayLength
     * @function
     *
     * @param {Object} obj the object to check
     *  
     * @description checks if the object is an array and the has a non-zero length
     * @return {Boolean} true if the object is an array and has a non-zero length; false otherwise
     * 
     */
    isArrayLength(obj) {
        try {
            if (this.isArray(obj) && obj.length > 0) {
                return true
            } else {
                return false
            }
        } catch (er) {
            return false
        }
    }

     /**
     * @name makeArray
     * @function
     *
     * @param {Array} arr the object to check
     *  
     * @description checks if the object is an array. It not it puts it in an empty array
     * @return {Array} the array object the object
     * 
     */
    makeArray(arr = []) {
        const arrayObject = []
        arrayObject.push(arr)
        return this.isArray(arr) ? arr : arrayObject
    }
    /**
     * @name parseJSON
     * @function
     *
     * @param {String} string the string to parse
     *  
     * @description JSON parses a string
     * @return {Object} the JSON.parsed object
     * 
     */
    parseJSON(string) {
        try {
            return JSON.parse(string)
        } catch (error) {
            return {}
        }
    }

     /**
     * @name jString
     * @function
     *
     * @param {String} string the string to JSON stringify
     *  
     * @description JSON stringifies a string
     * @return {Object} the JSON.stringified object
     * 
     */
    jString(string) {
        try {
            return JSON.stringify(string) //, replacer, key, value, space)
        } catch (error) {
            return {}
        }
    }

     /**
     * @name hash
     * @function
     *
     * @param {String} string the string to hash
     *  
     * @description hashes a string 
     * @return {String} the hashed string
     * 
     */
    hash(string) {
        if (typeof string == 'string' && string.trim().length > 0) {
            const hash = require('crypto').createHmac(Env.PASSWORD._HASH._METHOD, Env.PASSWORD._HASH._SECRET).update(string).digest('hex');
            return hash;
        } else {
            return false;
        }

    };

    /**
     * @name createRandomString
     * @function
     *
     * @param {String} string the string to hash
     *  
     * @description creates a string of random alpha numeric characters for a given string length
     * @return {String} the random string
     * 
     */

    createRandomString(stringLength) {
        stringLength = typeof stringLength == 'number' && stringLength > 0 ? stringLength : false;

        if (stringLength) {
            // Define all the possible characters  that could go in a string.
            const possibleCharacters = 'abcdefghklmnopqrstxvwyz0123456789ABCEFGHKLMNOPQRSTVWXYZ';
            // star the final string
            let string = '';
            for (let i = 0; i < stringLength; i++) {
                //  Get a random character from the possibleCharacters string
                let randomCharacter = possibleCharacters.charAt(Math.floor(Math.random() * possibleCharacters.length));
                //  Append this character  to the final string
                string += randomCharacter;
            }
            // return final string
            return string;
        } else {
            return false;
        }
    };

     /**
     * @name getRandomInt
     * @function
     *
     * @param {Number} min the minimum value of the random number to generate
     * @param {Number} max the maximum value of the random number to generate
     *  
     * @description generates a random number from a minimum value and maximum value
     * 
     * @return {String} the random number
     * 
     */
    getRandomInt(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min)) + min; //The maximum is exclusive and the minimum is inclusive
    }

    /**
     * @name generateOrderNumberFirstSet
     * @function
     *  
     * @description generates the first set of number of the first part of the order number
     * 
     * @return {String} the first set of number: 3 numbers
     * 
     */
    generateOrderNumberFirstSet() {
        let first = this.getRandomInt(0, 999)
        let fzeros = ''
        if (first.toString().length < 3) {
            let diff = 3 - first.toString().length

            while (fzeros.length < diff) {
                fzeros += '0'
            }

        }
        return `${this.randomLetterGen()}${fzeros}${first.toString()}`
    }

     /**
     * @name generateOrderNumberSecondSet
     * @function
     *  
     * @description generates the second set of number of the second part of the order number
     * 
     * @return {String} the second set of number: 7 numbers
     * 
     */
    generateOrderNumberSecondSet() {
        let second = this.getRandomInt(0, 9999999)
        let szeros = ''
        if (second.toString().length < 7) {
            let diff = 7 - second.toString().length

            while (szeros.length < diff) {
                szeros += '0'
            }
        }
        return `${this.randomLetterGen()}${szeros}${second.toString()}`
    }
     /**
     * @name generateOrderNumberThirdSet
     * @function
     *  
     * @description generates the third set of number of the third part (or last part) of the order number
     * 
     * @return {String} the third set of number: 10 numbers
     * 
     */
    generateOrderNumberThirdSet() {
        let third = this.getRandomInt(0, 9999999999)
        let tzeros = ''
        if (third.toString().length < 10) {
            let diff = 7 - third.toString().length

            while (tzeros.length < diff) {
                tzeros += '0'
            }

        }
        return `${this.randomLetterGen()}${tzeros}${third.toString()}`
    }

    /**
     * @name generateOrderNumber
     * @function
     *  
     * @description generates order numbers
     * 
     * @return {String} the generated order number
     * 
     */
    generateOrderNumber() {
        const sfinal = this.generateOrderNumberSecondSet()
        const ffinal = this.generateOrderNumberFirstSet()
        const tfinal = this.generateOrderNumberThirdSet()
        const final = `ORDER# ${ffinal}-${sfinal}-${tfinal}`
        return final
    }

    /**
     * @name orderPrice
     * @function
     * 
     * @param {Array} products the order products list
     * 
     * @description calculates order total prices
     * 
     * @return {String} the order total price
     * 
     */
    orderPrice(products = []) {
        if (products && products.length > 0) {
            const subtotal = products
                .map(datum => parseFloat(datum.pricing.subtotal.substring(1)))
                .reduce((x, y) => x + y, 0)

            // const quantity = this.products
            //   .map(datum => parseInt(datum.pricing.quantity))
            //   .reduce((x, y) => x + y, 0)

            const taxing = 0.07 * subtotal
            // const taxed = taxing.toFixed(2)

            const totaling = taxing + subtotal
            const total = totaling.toFixed(2)
            return total
        } else {
            return '0.00'
        }
    }
    /**
     * @name pluralize
     * @function
     * 
     * @param {String} item the item name
     * @param {Number} quantity the item quantity
     * 
     * @description builds the plural forms for regular words
     * 
     * @return {String} return the words either singular or plural
     * 
     */
    pluralize(item, quantity) {
        return (quantity > 1 ? `${item}s` : `${item}`)
    };

    /**
     * @name run
     * @function
     * 
     * @param {String} commands the bash command to run
     * @param {Object} options the options for the bash command
     * @param {Function} fn the callback function
     * 
     * @description sends emails, sms; processes payments, and executes schedules, and much more ...
     * 
     * @return {Function} function that executes the chil_process command
     * 
     */

    async run(commands = 'ls -las', options = {}, fn = () => {}) {
        return require('child_process').exec(commands, options, fn);
    }


      /**
     * @name maxString
     * @function
     * 
     * @param {String} a the string
     * 
     * @description sorts at string 
     * @return {Function} the sorted string
     * 
     */

    maxString(a) {
        return [...a].sort().pop()
    }

     /**
     * @name randomLetterGen
     * @function
     * 
     * @description generates a random letter from A to Z 
     * @return {String} the random letter
     * 
     */
    randomLetterGen() {
        const min = 'A'.charCodeAt()
        const max = 'Z'.charCodeAt()
        return String.fromCharCode(Math.floor(Math.random() * (1 + max - min)) + min)
    }

    /**
     * @name getRandomFileNames
     * @function
     * 
     * @param {String} fileExtension the file extension name
     * 
     * @description generates a random file name
     * 
     * @return {String} the generated file name
     * 
     */
    getRandomFileNames(fileExtension = '') {
        const NAME_LENGTH = 12
        let namePart = new Array(NAME_LENGTH)
        for (let i = 0; i < NAME_LENGTH; i++) {
            namePart[i] = randomLetterGen()
        }
        return namePart.join('') + fileExtension
    }

    

     /**
     * @name formFieldRegexes
     * @function
     * 
     * @description stores all the form field regexes
     * 
     * @return {Object} all the form field regexes
     * 
     */
    formFieldRegexes() {
        return {
            phone: /^[0-9]{3}([\- ]?)[0-9]{3}([\- ]?)[0-9]{4}$/gm,
            password: /^(?=.*[0-9])(?=.*[=#$%^+&*()_\-{}:;',.\`|/~[\])(?=.*[A-Z])(?=.*[a-z])[^ \f\n\r\t\v\u00a0\u1680\u2000-\u200a\u2028\u2029\u202f\u205f\u3000\ufeff]{8,15}$/gm,
            passwordConfirmation: /^(?=.*[0-9])(?=.*[=#$%^+&*()_\-{}:;',.\`|/~[\])(?=.*[A-Z])(?=.*[a-z])[^ \f\n\r\t\v\u00a0\u1680\u2000-\u200a\u2028\u2029\u202f\u205f\u3000\ufeff]{8,15}$/gm,
            firstname: /^[A-Z][A-Za-z.'\-].{0,25}$/gm,
            lastname: /^[A-Z][A-Za-z.'\-].{0,25}$/gm,
            username: /^[A-Za-z.'\-].{0,25}\S*$/gm,
            nickname: /^[A-Za-z.'\-].{0,25}\S*$/gm,
            email: /^[A-Za-z0-9_.%+-]+@[A-Za-z0-9_.-]+\.[A-Za-z.].{1,3}\S*$/gm,
            subject: /^([a-zA-Z0-9_.\ -?!]).{0,100}$/gm,
            email1: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/gm,
            // Amex Card 
            amexNumber: /^3[47][0-9]{2}([\- ]?)[0-9]{6}([\- ]?)[0-9]{5}$/gm,
            amexSecurityCode: /^[0-9]{4}$/gm,
            amexNameOnCard: /^[A-Z][A-Za-z.'\-].{0,25}$/gm,
            amexExpirationDate: /^(0?[1-9]|1[0-2])[-/](20[2-3][0-9]|2030)$/gm,
            // Visa Card 
            visaNumber: /^(?:4000)([\- ]?)[0-9]{4}([\- ]?)[0-9]{4}([\- ]?)[0-9]{4}$/gm,
            visaSecurityCode: /^[0-9]{3}$/gm,
            visaNameOnCard: /^[A-Z][A-Za-z.'\-].{0,25}$/gm,
            visaExpirationDate: /^(0?[1-9]|1[0-2])[-/](20[2-3][0-9]|2030)$/gm,
            // Master Card
            masterNumber: /^(?:5100)([\- ]?)[0-9]{4}([\- ]?)[0-9]{4}([\- ]?)[0-9]{4}$/gm,
            masterSecurityCode: /^[0-9]{3}$/gm,
            masterNameOnCard: /^[A-Z][A-Za-z.'\-].{0,25}$/gm,
            masterExpirationDate: /^(0?[1-9]|1[0-2])[-/](20[2-3][0-9]|2030)$/gm,
            // Discover
            discoverNumber: /^(?:6011)([\- ]?)[0-9]{4}([\- ]?)[0-9]{4}([\- ]?)[0-9]{4}$/gm,
            discoverSecurityCode: /^[0-9]{3}$/gm,
            discoverNameOnCard: /^[A-Z][A-Za-z.'\-].{0,25}$/gm,
            discoverExpirationDate: /^(0?[1-9]|1[0-2])[-/](20[2-3][0-9]|2030)$/gm,


            // Zip Code 
            zip: '',
            // city 
            city: '',
            // State
            state: '',
            // Country
            country: /^USA$/gm
        }
    }
     /**
     * @name isRegexValid
     * @function
     * 
     * @param {RegExp} regex the regest to be tested against a string
     * @param {String} input the string to be tested against the regex
     * 
     * @description tests a string against a regex
     * 
     * @return {Boolean} the test result: true of the the matches the regex; false otherwise
     * 
     */
    isRegexValid(regex, input) {
        return regex.test(input)
    }

    /**
     * @name validate
     * @function
     * 
     * @param {String} fieldName  the string to be tested against the regex
     * 
     * @description validates a form field input value against a regex
     * 
     * @return {Boolean} the test result: true of the the matches the regex; false otherwise
     * 
     */
    validate(fieldName){
       return  this.isRegexValid(this.formFieldRegexes()[fieldName], fieldName)
    }

     /**
     * @name validatePhone
     * @function
     * 
     * @param {String} phone the phone number 
     * 
     * @description tests the phone number string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the phone number string matches the regex; false otherwise
     * 
     */
    validatePhone(phone) //{return this.validate(phone)}
       { return this.isRegexValid(this.formFieldRegexes().phone, phone)}
     /**
     * @name validateFirstname
     * @function
     * 
     * @param {String} firstname the first name 
     * 
     * @description tests the first name string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the first name string matches the regex; false otherwise
     * 
     */
    validateFirstname(firstname) //{return this.validate(firstname)}
    { return this.isRegexValid(this.formFieldRegexes().firstname, firstname)}
    //}

    /**
     * @name validateLastname
     * @function
     * 
     * @param {String} lastname the last name 
     * 
     * @description tests the last name string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the last name string matches the regex; false otherwise
     * 
     */
    validateLastname(lastname) //{return this.validate(lastname)}
        {return this.isRegexValid(this.formFieldRegexes().lastname, lastname)}
    // }

    /**
     * @name validateEmail
     * @function
     * 
     * @param {String} email the email 
     * 
     * @description tests the email string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the email string matches the regex; false otherwise
     * 
     */
    validateEmail(email) //{return this.validate(email)}
      {return this.isRegexValid(this.formFieldRegexes().email, email)}
    // }

    /**
     * @name validateUsername
     * @function
     * 
     * @param {String} username the username 
     * 
     * @description tests the username string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the username string matches the regex; false otherwise
     * 
     */
    validateUsername(username) ///{return this.validate(username)} //{
       { return this.isRegexValid(this.formFieldRegexes().username, username)}
    // }

    /**
     * @name validatePassword
     * @function
     * 
     * @param {String} password the password 
     * 
     * @description tests the password string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the password string matches the regex; false otherwise
     * 
     */
    validatePassword(password) //{return this.validate(password)} //{
        {return this.isRegexValid(this.formFieldRegexes().password, password)}
    // }

    /**
     * @name validateNickname
     * @function
     * 
     * @param {String} nickname the nickname 
     * 
     * @description tests the nickname string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the nickname string matches the regex; false otherwise
     * 
     */
    validateNickname(nickname) //{return this.validate(nickname)}//{
        {return this.isRegexValid(this.formFieldRegexes().nickname, nickname)}
    // }

    /**
     * @name validateSubject
     * @function
     * 
     * @param {String} subject the contact us message subject 
     * 
     * @description tests the contact us message subject string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the contact us message subject string matches the regex; false otherwise
     * 
     */
    validateSubject(subject) ///{return this.validate(subject)}//{
     { return this.isRegexValid(this.formFieldRegexes().subject, subject)}
    // }
    // Payment 

    // Amex Card

    /**
     * @name validateAmexNumber
     * @function
     * 
     * @param {String}  amexNumber the American Express card number 
     * 
     * @description tests the American Express card number string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the American Express card number string matches the regex; false otherwise
     * 
     */
    validateAmexNumber(amexNumber) //{return this.validate(amexNumber)}//{
        {return this.isRegexValid(this.formFieldRegexes().amexNumber, amexNumber)}
    // }

    /**
     * @name validateAmexExpirationDate
     * @function
     * 
     * @param {String} amexExpirationDate the American Express card expiration date 
     * 
     * @description tests the American Express card expiration date string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the American Express card expiration date string matches the regex; false otherwise
     * 
     */
    validateAmexExpirationDate(amexExpirationDate)
       { return this.isRegexValid(this.formFieldRegexes().amexExpirationDate, amexExpirationDate)}


    /**
     * @name validateAmexNameOnCard
     * @function
     * 
     * @param {String} amexNameOnCard the name on the American Express card 
     * 
     * @description tests the name on the American Express card string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the name on the American Express card string matches the regex; false otherwise
     * 
     */
    validateAmexNameOnCard(amexNameOnCard) //{return this.validate(amexNameOnCard)}
     {return this.isRegexValid(this.formFieldRegexes().amexNameOnCard, amexNameOnCard)}

    /**
     * @name validateAmexSecurityCode
     * @function
     * 
     * @param {String} amexSecurityCode the American Express card 
     * 
     * @description tests the American Express card string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the American Express card string matches the regex; false otherwise
     * 
     */
    validateAmexSecurityCode(amexSecurityCode) 
 {return this.isRegexValid(this.formFieldRegexes().amexSecurityCode, amexSecurityCode)}


    // Visa Card 
    /**
     * @name validateVisaNumber
     * @function
     * 
     * @param {String} visaNumber the Visa Card number 
     * 
     * @description tests the Visa Card number string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the Visa Card number string matches the regex; false otherwise
     * 
     */
    validateVisaNumber(visaNumber) {return this.validate(visaNumber)}//{
    //     return this.isRegexValid(this.formFieldRegexes().visaNumber, visaNumber)
    // }
    /**
     * @name validateVisaExpirationDate
     * @function
     * 
     * @param {String} visaExpirationDate the Visa Card expiration date
     * 
     * @description tests the Visa Card expiration datestring against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the Visa Card expiration datestring matches the regex; false otherwise
     * 
     */
    validateVisaExpirationDate(visaExpirationDate) {return this.validate(visaExpirationDate)}// {
    //     return this.isRegexValid(this.formFieldRegexes().visaExpirationDate, visaExpirationDate)
    // }
    /**
     * @name validateVisaNameOnCard
     * @function
     * 
     * @param {String} visaNameOnCard the name of Visa Card 
     * 
     * @description tests the name of Visa Card string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the name of Visa Card string matches the regex; false otherwise
     * 
     */
    validateVisaNameOnCard(visaNameOnCard){return this.validate(visaNameOnCard)}// {
    //     return this.isRegexValid(this.formFieldRegexes().visaNameOnCard, visaNameOnCard)
    // }

    /**
     * @name validateVisaSecurityCode
     * @function
     * 
     * @param {String} visaSecurityCode the Visa Card security code 
     * 
     * @description tests the Visa Card security code string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the Visa Card security code string matches the regex; false otherwise
     * 
     */
    validateVisaSecurityCode(visaSecurityCode) {return this.validate(visaSecurityCode)}//{
    //     return this.isRegexValid(this.formFieldRegexes().visaSecurityCode, visaSecurityCode)
    // }

    // Master Card
    /**
     * @name validateMasterNumber
     * @function
     * 
     * @param {String} masterNumber the Master card number 
     * 
     * @description tests the Master card number string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the Master card number string matches the regex; false otherwise
     * 
     */
    validateMasterNumber(masterNumber){return this.validate(masterNumber)}// {
    //     return this.isRegexValid(this.formFieldRegexes().masterNumber, masterNumber)
    // }

    /**
     * @name validateMasterExpirationDate
     * @function
     * 
     * @param {String} masterExpirationDate the Master card expiration date 
     * 
     * @description tests the Master card expiration date string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the Master card expiration date string matches the regex; false otherwise
     * 
     */
    validateMasterExpirationDate(masterExpirationDate){return this.validate(masterExpirationDate)}// {
    //     return this.isRegexValid(this.formFieldRegexes().masterExpirationDate, masterExpirationDate)
    // }

    /**
     * @name validateMasterNameOnCard
     * @function
     * 
     * @param {String} masterNameOnCard the name of Master card 
     * 
     * @description tests the name of Master card string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the name of Master card string matches the regex; false otherwise
     * 
     */
    validateMasterNameOnCard(masterNameOnCard) {return this.validate(masterNameOnCard)} //{
    //     return this.isRegexValid(this.formFieldRegexes().masterNameOnCard, masterNameOnCard)
    // }

    /**
     * @name validateMasterSecurityCode
     * @function
     * 
     * @param {String} masterSecurityCode the Master card security code 
     * 
     * @description tests the Master card security code string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the Master card security code string matches the regex; false otherwise
     * 
     */
    validateMasterSecurityCode(masterSecurityCode) {return this.validate(masterSecurityCode)}//{
    //     return this.isRegexValid(this.formFieldRegexes().masterSecurityCode, masterSecurityCode)
    // }

    // Discover Card 

    /**
     * @name validateDiscoverNumber
     * @function
     * 
     * @param {String} discoverNumber the Discover card number 
     * 
     * @description tests the Discover card number string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the Discover card number string matches the regex; false otherwise
     * 
     */
    validateDiscoverNumber(discoverNumber) {return this.validate(discoverNumber)}//{
    //     return this.isRegexValid(this.formFieldRegexes().discoverNumber, discoverNumber)
    // }

    /**
     * @name validateDiscoverExpirationDate
     * @function
     * 
     * @param {String} discoverExpirationDate the Discover card expiration date 
     * 
     * @description tests the Discover card expiration date string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the Discover card expiration date string matches the regex; false otherwise
     * 
     */
    validateDiscoverExpirationDate(discoverExpirationDate) {return this.validate(discoverExpirationDate)}// {
    //     return this.isRegexValid(this.formFieldRegexes().discoverExpirationDate, discoverExpirationDate)
    // }
    /**
     * @name validateDiscoverNameOnCard
     * @function
     * 
     * @param {String} discoverNameOnCard the name on Discover card 
     * 
     * @description tests the name on Discover card string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the name on Discover card string matches the regex; false otherwise
     * 
     */
    validateDiscoverNameOnCard(discoverNameOnCard) {return this.validate(discoverNameOnCard)}//{
    //     return this.isRegexValid(this.formFieldRegexes().discoverNameOnCard, discoverNameOnCard)
    // }

    /**
     * @name validateDiscoverSecurityCode
     * @function
     * 
     * @param {String} discoverSecurityCode the Discover card security code 
     * 
     * @description tests the Discover card security code string against its corresponding form field regex
     * 
     * @return {Boolean} the test result: true if the Discover card security code string matches the regex; false otherwise
     * 
     */
    validateDiscoverSecurityCode(discoverSecurityCode) {return this.validate(discoverSecurityCode)}//{
    //     return this.isRegexValid(this.formFieldRegexes().discoverSecurityCode, discoverSecurityCode)
    // }

    /**
     * @name validateCountry
     * @function
     * 
     * @param {String} country the country name 
     * 
     * @description tests the country name string against its corresponding form field regex
     * @return {Boolean} the test result: true if the country name string matches the regex; false otherwise
     * 
     */
    validateCountry(country) {return this.validate(country)}//{
    //     return this.isRegexValid(this.formFieldRegexes().country, country)
    // }

    /**
     * @name validateInputData
     * @function
     * 
     * @param {Object} data the request payload
     * 
     * @description tests each form field value against its corresponding regex
     * @return {Object} emitter, emit an invalid event upon test fail
     * 
     */
    validateInputData(data = {}) {
        if (data && data.payload) {
            for (let payload in data.payload) {
                const firstLetter = payload.slice(-payload.length, 1).toLocaleUpperCase()
                const rest = payload.slice(1, payload.length)
                const string = `${firstLetter}${rest}`
                const method = `validate`.concat(string)
                    if (this[method] !== undefined) {
                        if (!this[method](data.payload[payload])) {
                            //handle errors
                            this.error[`${payload}`] = `Invalid ${payload}`
                            this.emit('invalid', this.error)
                            this.error = {}
                            break
                        }
                    }
                    // console.log('this[method]',this[method](data.payload[payload]))
            }
        }
    //   const getReg =  (fieldName) => this.isRegexValid(this.formFieldRegexes() 
    // console.log(this.validateFirstname('firstname'))
    }

    toasterOptions (options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "100",
    "hideDuration": "100",
    "timeOut": "2000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "show",
    "hideMethod": "hide"
}){
        return options
    }
}

</script>