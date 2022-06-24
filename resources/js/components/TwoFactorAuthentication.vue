<template>
    <div>
        <h3 class="tab-header card-header" v-if="twoFactorEnabled">
            {{__('auth.two_factor_authentication.is_enabled')}}
        </h3>
        <h3 class="tab-header card-header" v-else>
            {{__('auth.two_factor_authentication.is_disabled')}}
        </h3>
        <form class="card-body" role="form" method="POST"
              :action="url('old.settings.twoFactorAuthentication.toggleURL')"
              @submit.prevent="toggleTwoFactorAuthentication()">
            <div class="mt-1">
                <p>
                    {{__('auth.two_factor_authentication.explanation')}}
                </p>
            </div>

            <div class="mt-5 mb-3" v-if="showingQrCode">
                <h3 class="tab-header mb-4">{{__('auth.two_factor_authentication.qr_code')}}</h3>
                <div class="my-2">
                    <p>
                        {{__('auth.two_factor_authentication.enabled_scan_qr_code')}}
                    </p>
                </div>
                <span v-html="qrCode"></span>
            </div>
            <div class="mt-5 mb-3" v-if="showingRecoveryCodes">
                <div>
                    <div>
                        <h3 class="tab-header mb-4">{{__('auth.two_factor_authentication.recovery_codes')}}</h3>
                        <p>{{__('auth.two_factor_authentication.recovery_code_explanation')}}</p>
                        <pre style="overflow: auto;word-break: break-all;word-wrap: break-word;margin:0"><code
                                style="white-space: pre-wrap;word-break: break-all;word-wrap: break-word;font-size: 1.2em"><div
                                v-for="code in recoveryCodes">{{code}}</div></code></pre>
                    </div>
                </div>
            </div>

            <input type="submit" id="user-2fa-submit" class="d-none">
        </form>

        <div class="card-footer d-flex">
            <form method="POST" :action="url('old.settings.twoFactorAuthentication.recoveryCodesURL')"
                  v-if="showingRecoveryCodes" @submit.prevent="regenerateRecoveryCodes()">
                <button class="btn btn-labeled btn-outline-secondary mb-0" type="submit">
                    <span class="btn-label"></span>{{__('auth.two_factor_authentication.regenerate_recovery_codes')}}
                </button>
            </form>
            <a class="btn btn-labeled btn-outline-secondary mb-0" href="#"
               v-if="twoFactorEnabled && !showingRecoveryCodes" @click.prevent="showRecoveryCodes()">
                <span class="btn-label"></span>{{__('auth.two_factor_authentication.show_recovery_codes')}}
            </a>
            <a class="btn btn-labeled btn-outline-secondary mb-0 ml-2" href="#"
               v-if="twoFactorEnabled && showingQrCodeButton" @click.prevent="showQrCode()">
                <span class="btn-label"></span>{{__('auth.two_factor_authentication.show_qr_code')}}
            </a>
            <label for="user-2fa-submit" class="btn btn-labeled btn-danger ml-auto mb-0 font-weight-bold"
                   v-if="twoFactorEnabled" dusk="two-factor-disable-button">
                <span class="btn-label"></span>{{__('auth.two_factor_authentication.disable')}}
            </label>
            <label for="user-2fa-submit" class="btn btn-labeled btn-common ml-auto mb-0"
                   v-if="!twoFactorEnabled" dusk="two-factor-enable-button">
                <span class="btn-label"></span>{{__('auth.two_factor_authentication.enable')}}
            </label>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                qrCode: '',
                recoveryCodes: [],

                showingQrCode: false,
                showingQrCodeButton: false,
                showingRecoveryCodes: false,
                twoFactorEnabled: false,

                dirty: false,
            };
        },

        props: ["enabled", "showQrCodeButton"],

        created() {
            window.addEventListener('beforeunload', this.confirmLeaving)
        },

        mounted() {
            this.twoFactorEnabled = this.enabled;
            this.showingQrCodeButton = this.showQrCodeButton;
        },

        methods: {
            url(key, obj) {
                return key.split('.').reduce(function (prev, curr) {
                    return prev ? prev[curr] : null
                }, obj || self)
            },
            trans(key) {
                return this.resolve(key);
            },
            __(key) {
                return this.resolve(key);
            },
            resolve(path, obj) {
                return this.$t(path);
            },
            confirmLeaving(event) {
                if (this.dirty) {
                    const unsaved_changes_warning = this.trans('auth.two_factor_authentication.old_browser_leave_warning');
                    event.returnValue = unsaved_changes_warning;
                    return unsaved_changes_warning;
                }
            },
            toggleTwoFactorAuthentication(response = null) {
                if (!response) {
                    // first we need to check the password status
                    return this.checkPasswordConfirmation(this.toggleTwoFactorAuthentication); // returns 'confirmed':true|false
                }
                if (!response.data.confirmed && !response.data.passwordConfirmed && !response.data.userConfirmed && !response.data.password) {
                    // if no recent password confirmation then ask
                    return this.getPasswordConfirmation(this.toggleTwoFactorAuthentication); // returns 'password':string
                }
                if (response.data.password) {
                    // send the password to the server to compare
                    swal.close();
                    return this.sendPasswordConfirmation(response.data.password, this.toggleTwoFactorAuthentication); // returns 'passwordConfirmed':true|false
                }
                if (!this.twoFactorEnabled) {
                    return this.enable2FA();
                }

                if (!response.data.userConfirmed) {
                    // here you can have a confirmation or do the actual work
                    return this.getDisable2faConfirmation(this.disable2FA); // returns 'userConfirmed':true|false
                } // no longer confirming 2fa code to disable, as there is really no need and requires custom endpoints/logic
                // we need to confirm 2fa code or recovery code before disabling
                return this.getDisableTwoFactorAuthenticationWithCode((code) => {
                        var response = (code.includes("-") && code.length === 21) ? {"recovery_code": code} : {"code": code};
                        axios.post(this.url('old.settings.twoFactorAuthentication.disableCheckURL'), response)
                            .then(response => {
                                return this.disable2FA();
                            })
                            .catch((error) => {
                                if (error.response) {
                                    if (error.response.status === 401) {
                                        return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.code_does_not_match'), "error");
                                    }
                                }
                                return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.there_was_an_error'), "error");
                            });
                    }
                );
            },
            showQrCode(response = null) {
                if (!this.twoFactorEnabled || !this.showingQrCodeButton || this.showingQrCode) {
                    return null;
                }
                if (!response) {
                    // first we need to check the password status
                    return this.checkPasswordConfirmation(this.showQrCode); // returns 'confirmed':true|false
                }
                if (!response.data.confirmed && !response.data.passwordConfirmed && !response.data.password) {
                    // if no recent password confirmation then ask
                    return this.getPasswordConfirmation(this.showQrCode); // returns 'password':string
                }
                if (response.data.password) {
                    // send the password to the server to compare
                    swal.close();
                    return this.sendPasswordConfirmation(response.data.password, this.showQrCode); // returns 'passwordConfirmed':true|false
                }
                return axios.get(this.url('old.settings.twoFactorAuthentication.qrCodeURL'))
                    .then(response => {
                        if (response.data.svg) {
                            this.qrCode = response.data.svg;
                            this.showingQrCode = true;
                        }
                    })
                    .catch((error) => {
                        return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.there_was_an_error'), "error");
                    });
            },
            showRecoveryCodes(response = null) {
                if (!this.twoFactorEnabled) {
                    return null;
                }
                if (!response) {
                    // first we need to check the password status
                    return this.checkPasswordConfirmation(this.showRecoveryCodes); // returns 'confirmed':true|false
                }
                if (!response.data.confirmed && !response.data.passwordConfirmed && !response.data.password) {
                    // if no recent password confirmation then ask
                    return this.getPasswordConfirmation(this.showRecoveryCodes); // returns 'password':string
                }
                if (response.data.password) {
                    // send the password to the server to compare
                    swal.close();
                    return this.sendPasswordConfirmation(response.data.password, this.showRecoveryCodes); // returns 'passwordConfirmed':true|false
                }
                // here you can have a confirmation or do the actual work
                return this.getRecoveryCodes();
            },
            regenerateRecoveryCodes(response = null) {
                if (!this.twoFactorEnabled) {
                    return null;
                }
                if (!response) {
                    // first we need to check the password status
                    return this.checkPasswordConfirmation(this.regenerateRecoveryCodes); // returns 'confirmed':true|false
                }
                if (!response.data.confirmed && !response.data.passwordConfirmed && !response.data.userConfirmed && !response.data.password) {
                    // if no recent password confirmation then ask
                    return this.getPasswordConfirmation(this.regenerateRecoveryCodes); // returns 'password':string
                }
                if (response.data.password) {
                    // send the password to the server to compare
                    swal.close();
                    return this.sendPasswordConfirmation(response.data.password, this.regenerateRecoveryCodes); // returns 'passwordConfirmed':true|false
                }
                if (!response.data.userConfirmed) {
                    // here you can have a confirmation or do the actual work
                    return this.getRegenerateRecoveryCodesConfirmation(this.regenerateRecoveryCodes); // returns 'userConfirmed':true|false
                }
                return axios.post(this.url('old.settings.twoFactorAuthentication.recoveryCodesURL'))
                    .then(response => {
                        swal(this.trans('auth.two_factor_authentication.success'), this.trans('auth.two_factor_authentication.recovery_codes_generated'), "success");
                        return this.getRecoveryCodes();
                    })
                    .catch((error) => {
                        return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.there_was_an_error'), "error");
                    });
            },
            getRegenerateRecoveryCodesConfirmation(callback, errorCallback = null) {
                swal({
                    title: this.trans('auth.two_factor_authentication.confirm_regeneration'),
                    text: this.trans('auth.two_factor_authentication.please_confirm_regeneration'),
                    icon: "warning",
                    buttons: {
                        cancel: this.trans('auth.two_factor_authentication.cancel'),
                        confirm: {
                            text: this.trans('auth.two_factor_authentication.confirm'),
                            value: true,
                            closeModal: false,
                        }
                    },
                    dangerMode: true,
                })
                    .then(confirmed => {
                        if (!confirmed) {
                            return null;
                        }
                        return callback({"data": {"userConfirmed": confirmed}});
                    })
                    .catch((error) => {
                        if (errorCallback) {
                            return errorCallback(error);
                        }
                        return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.there_was_an_error'), "error");
                    });
            },
            getDisable2faConfirmation(callback, errorCallback = null) {
                swal({
                    title: this.trans('auth.two_factor_authentication.confirm_disable'),
                    text: this.trans('auth.two_factor_authentication.please_confirm_disable'),
                    icon: "warning",
                    buttons: {
                        cancel: this.trans('auth.two_factor_authentication.cancel'),
                        confirm: {
                            text: this.trans('auth.two_factor_authentication.disable_'),
                            value: true,
                            closeModal: false,
                        }
                    },
                    dangerMode: true,
                })
                    .then(confirmed => {
                        if (!confirmed) {
                            return null;
                        }
                        return callback({"data": {"userConfirmed": confirmed}});
                    })
                    .catch((error) => {
                        if (errorCallback) {
                            return errorCallback(error);
                        }
                        return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.there_was_an_error'), "error");
                    });
            },
            sendPasswordConfirmation(password, callback, errorCallback = null) {
                axios.post(this.url('old.settings.twoFactorAuthentication.confirmPasswordURL'), {"password": password})
                    .then(results => {
                        // if (!results) throw null;

                        return callback({"data": {"passwordConfirmed": true}});
                    })
                    .catch((error) => {
                        if (errorCallback) {
                            return errorCallback(error);
                        }
                        if (error.response) {
                            if (error.response.status === 422) {
                                return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.password_does_not_match'), "error");
                            }
                            return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.there_was_an_error'), "error");
                        }
                    });
            },
            getPasswordConfirmation(callback, errorCallback = null) {
                swal({
                    title: this.trans('auth.two_factor_authentication.confirm_password'),
                    text: this.trans('auth.two_factor_authentication.please_confirm_password'),
                    content: {
                        element: "input",
                        attributes: {
                            placeholder: this.trans('auth.two_factor_authentication.password'),
                            type: "password",
                        },
                    },
                    buttons: {
                        cancel: this.trans('auth.two_factor_authentication.cancel'),
                        confirm: {
                            text: this.trans('auth.two_factor_authentication.confirm'),
                            closeModal: false,
                        }
                    },
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                })
                    .then(password => {
                        if (!password) {
                            swal.close();
                            return null;
                        }
                        return callback({"data": {"password": password}});
                    })
                    .catch((error) => {
                        if (errorCallback) {
                            return errorCallback(error);
                        }
                        return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.there_was_an_error'), "error");
                    });
            },
            checkPasswordConfirmation(callback, errorCallback = null) {
                axios.get(this.url('old.settings.twoFactorAuthentication.confirmedPasswordStatusURL'))
                    .then(response => {
                        return callback(response);
                    })
                    .catch((error) => {
                        if (errorCallback) {
                            return errorCallback(error);
                        }
                        return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.there_was_an_error'), "error");
                    });
            },
            getDisableTwoFactorAuthenticationConfirmation(callback, errorCallback = null) {
                swal({
                    title: this.trans('auth.two_factor_authentication.confirm_disable'),
                    text: this.trans('auth.two_factor_authentication.please_confirm_disable'),
                    icon: "warning",
                    buttons: {
                        cancel: this.trans('auth.two_factor_authentication.cancel'),
                        confirm: {
                            text: this.trans('auth.two_factor_authentication.disable_'),
                            value: true,
                            closeModal: false,
                        }
                    },
                    dangerMode: true,
                })
                    .then(confirmed => {
                        if (!confirmed) {
                            return null;
                        }
                        return callback({"data": {"userConfirmed": confirmed}});
                    })
                    .catch((error) => {
                        if (errorCallback) {
                            return errorCallback(error);
                        }
                        return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.there_was_an_error'), "error");
                    });
            },
            getDisableTwoFactorAuthenticationWithCode(callback, errorCallback = null) {
                swal({
                    title: this.trans('auth.two_factor_authentication.confirm_app_code'),
                    text: this.trans('auth.two_factor_authentication.please_confirm_app_code'),
                    content: {
                        element: "input",
                        attributes: {
                            placeholder: this.trans('auth.two_factor_authentication.code'),
                        },
                    },
                    buttons: {
                        cancel: this.trans('auth.two_factor_authentication.cancel'),
                        confirm: {
                            text: this.trans('auth.two_factor_authentication.disable'),
                            closeModal: false,
                        }
                    },
                    dangerMode: true,
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                })
                    .then(code => {
                        if (!code) {
                            swal.close();
                            return null;
                        }
                        return callback(code);
                    })
                    .catch((error) => {
                        if (errorCallback) {
                            return errorCallback(error);
                        }
                        return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.there_was_an_error'), "error");
                    });
            },
            enable2FA() {
                this.dirty = true;
                axios.post(this.url('old.settings.twoFactorAuthentication.toggleURL'))
                    .then(response => {
                        return this.getRecoveryCodes();
                    })
                    .catch((error) => {
                        axios.delete(this.url('old.settings.twoFactorAuthentication.toggleURL'));
                        this.dirty = false;
                        return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.there_was_an_error'), "error");
                    });
            },
            disable2FA() {
                axios.delete(this.url('old.settings.twoFactorAuthentication.toggleURL'))
                    .then(response => {
                        return this.getRecoveryCodes();
                    })
                    .catch((error) => {
                        this.dirty = false;
                        return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.there_was_an_error'), "error");
                    });
            },
            getRecoveryCodes() {
                axios.get(this.url('old.settings.twoFactorAuthentication.recoveryCodesURL'))
                    .then(response => {
                        if (Array.isArray(response.data) && response.data.length > 0) {
                            this.recoveryCodes = response.data;
                            if (this.twoFactorEnabled) {
                                this.showingRecoveryCodes = true;
                                return null;
                            }
                            return this.getQrCode();
                        }
                        // it gets to here before confirming disabled as we are sure because the recovery codes are gone
                        this.twoFactorEnabled = false;
                        this.showingRecoveryCodes = false;
                        this.showingQrCode = false;
                        this.recoveryCodes = [];
                        this.dirty = false;
                        return swal(this.trans('auth.two_factor_authentication.success'), this.trans('auth.two_factor_authentication.has_been_disabled'), "success");
                    })
                    .catch((error) => {
                        axios.delete(this.url('old.settings.twoFactorAuthentication.toggleURL'));
                        this.dirty = false;
                        return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.there_was_an_error'), "error");
                    });
            },
            getQrCode(callback = null, errorCallback = null) {
                axios.get(this.url('old.settings.twoFactorAuthentication.qrCodeURL'))
                    .then(response => {
                        if (callback) {
                            return callback(response);
                        }
                        if (response.data.svg) {
                            this.qrCode = response.data.svg;
                            return this.showConfirmCodeModal(response.data.svg);
                        } else {
                            this.qrCode = '';
                        }
                    })
                    .catch((error) => {
                        if (errorCallback) {
                            return errorCallback(error);
                        }
                        axios.delete(this.url('old.settings.twoFactorAuthentication.toggleURL'));
                        this.dirty = false;
                        return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.there_was_an_error'), "error");
                    });
            },
            showConfirmCodeModal(qrCode) {
                var span = document.createElement("span");
                span.innerHTML = qrCode + '<input type="text" inputmode="numeric" pattern="[0-9]*" id="swal-input1" class="swal-content__input mt-3" placeholder="' + this.trans('auth.two_factor_authentication.code') + '" autocomplete="off"><img src="//:0" class="d-none" onerror="setTimeout(function(){ $(\'#swal-input1\').focus();$(\'#swal-input1\').on(\'keydown\', function(event) {if(event.which == 13){$(\'#swal-input1\').parent().parent().parent().parent().find(\'.swal-button--confirm\').trigger(\'click\');}}); }, 500) ">'; // JESUS! This is to get around sweetalert limitations
                swal({
                    title: this.trans('auth.two_factor_authentication.confirm_app_code'),
                    text: this.trans('auth.two_factor_authentication.enter_authenticator_app_code'),
                    content: {
                        element: span
                    },
                    buttons: {
                        confirm: {
                            text: this.trans('auth.two_factor_authentication.confirm'),
                            closeModal: false,
                        }
                    },
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                })
                    .then(submittedCode => {
                        if (!this.twoFactorEnabled) {
                            return this.confirmCode();
                        }
                    })
                    .catch((error) => {
                        axios.delete(this.url('old.settings.twoFactorAuthentication.toggleURL'));
                        this.dirty = false;
                        return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.there_was_an_error'), "error");
                    });
            },
            confirmCode() {
                axios.post(this.url('old.settings.twoFactorAuthentication.enableCheckURL'), {
                    "code": $('#swal-input1').val(),
                    "user_id": old.auth.user.id
                })
                    .then(response => {
                        this.twoFactorEnabled = true;
                        this.showingRecoveryCodes = true;
                        this.dirty = false;
                        return swal(this.trans('auth.two_factor_authentication.success'), this.trans('auth.two_factor_authentication.has_been_enabled'), "success");
                    })
                    .catch((error) => {
                        axios.delete(this.url('old.settings.twoFactorAuthentication.toggleURL'));
                        this.dirty = false;
                        if (error.response) {
                            if (error.response.status === 401) {
                                return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.code_does_not_match'), "error");
                            }
                        }
                        return swal(this.trans('auth.two_factor_authentication.sorry'), this.trans('auth.two_factor_authentication.there_was_an_error'), "error");
                    });
            },
        }
    }
</script>
