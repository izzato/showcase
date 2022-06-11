<template>
    <div>
        <h3 class="tab-header card-header" v-if="twoFactorEnabled">
            {{__('sdx.settings.twoFactorAuthentication.isEnabled')}}
        </h3>
        <h3 class="tab-header card-header" v-else>
            {{__('sdx.settings.twoFactorAuthentication.isDisabled')}}
        </h3>
        <form class="card-body" role="form" method="POST" :action="url('sdx.settings.twoFactorAuthentication.toggleURL')" @submit.prevent="toggleTwoFactorAuthentication()">
            <div class="mt-1">{{__('sdx.settings.twoFactorAuthentication.explanation')}}</div>

            <div class="mt-3" v-if="showingQrCode">
                <div class="my-2 text-bold">{{__('sdx.settings.twoFactorAuthentication.enabledScanQrCode')}}</div>
                <span v-html="qrCode"></span>
            </div>
            <div class="mt-3 mb-3" v-if="showingRecoveryCodes">
                <div class="alert-box">
                    <div class="alert alert-warning" role="alert">
                      <h3 class="alert-heading">These recovery codes will only be shown once!</h3>
                      <p>{{__('sdx.settings.twoFactorAuthentication.recoveryCodeExplanation')}}</p>
                        <pre style="overflow: auto;word-break: break-all;word-wrap: break-word;margin:0"><code style="white-space: pre-wrap;word-break: break-all;word-wrap: break-word;font-size: 1.2em"><div v-for="code in recoveryCodes">{{code}}</div></code></pre>
                    </div>
                  </div>
            </div>

            <input type="submit" id="user-2fa-submit" class="d-none">
        </form>

        <div class="card-footer d-flex">
<!--            <form method="POST" action="{{url('sdx.settings.twoFactorAuthentication.recoveryCodesURL')}}" v-if="showingRecoveryCodes" @submit.prevent="regenerateRecoveryCodes()">-->
<!--                <button class="btn btn-labeled btn-secondary mb-0 text-uppercase" type="submit">-->
<!--                    <span class="btn-label"><i class="fa fa-sync-alt"></i></span>{{__('sdx.settings.twoFactorAuthentication.regenerateRecoveryCodes')}}-->
<!--                </button>-->
<!--            </form>-->
<!--            <a class="btn btn-labeled btn-secondary mb-0 text-uppercase" href="#" v-if="twoFactorEnabled && !showingRecoveryCodes" @click.prevent="showRecoveryCodes()">-->
<!--                <span class="btn-label"><i class="fa fa-eye"></i></span>{{__('sdx.settings.twoFactorAuthentication.showRecoveryCodes')}}-->
<!--            </a>-->
<!--            <a class="btn btn-labeled btn-secondary mb-0 text-uppercase ml-2" href="#" v-if="twoFactorEnabled && showingQrCodeButton" @click.prevent="showQrCode()">-->
<!--                <span class="btn-label"><i class="fa fa-eye"></i></span>{{__('sdx.settings.twoFactorAuthentication.showQrCode')}}-->
<!--            </a>-->
            <label for="user-2fa-submit" tabindex="0" class="btn btn-labeled btn-danger ml-auto mb-0 text-uppercase font-weight-bold" v-if="twoFactorEnabled" dusk="two-factor-disable-button">
                <span class="btn-label"><i class="fa fa-times"></i></span>{{__('sdx.settings.twoFactorAuthentication.disable')}}
            </label>
            <label for="user-2fa-submit" tabindex="0" class="btn btn-labeled btn-primary ml-auto mb-0" v-if="!twoFactorEnabled" dusk="two-factor-enable-button">
                <span class="btn-label"><i class="fa fa-check"></i></span>{{__('sdx.settings.twoFactorAuthentication.enable')}}
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

        props: ["enabled","showQrCodeButton"],

        created() {
            window.addEventListener('beforeunload', this.confirmLeaving)
        },

        mounted() {
            this.twoFactorEnabled = this.enabled;
            this.showingQrCodeButton = this.showQrCodeButton;
        },

        methods: {
            url(key) {
                return this.resolve(key);
            },
            trans(key) {
                return this.resolve(key);
            },
            __(key) {
                return this.resolve(key);
            },
            resolve(path, obj) {
                return path.split('.').reduce(function(prev, curr) {
                    return prev ? prev[curr] : null
                }, obj || self)
            },
            confirmLeaving(event) {
                if (this.dirty) {
                    const unsaved_changes_warning = this.trans('sdx.settings.twoFactorAuthentication.oldBrowserLeaveWarning');
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
                // we need to confirm 2fa code or recovery code before disabling
                return this.getDisableTwoFactorAuthenticationWithCode((code) => {
                    var response = (code.includes("-") && code.length === 21) ? {"recovery_code": code} : {"code": code};
                    axios.post(this.url('sdx.settings.twoFactorAuthentication.disableCheckURL'), response)
                        .then(response => {
                            return this.disable2FA();
                        })
                        .catch((error) => {
                            if (error.response) {
                                if (error.response.status === 401) {
                                    return swal(this.trans('sdx.settings.twoFactorAuthentication.sorry'), this.trans('sdx.settings.twoFactorAuthentication.codeDoesNotMatch'), "error");
                                }
                            }
                            return swal(this.trans('sdx.settings.twoFactorAuthentication.sorry'), this.trans('sdx.settings.twoFactorAuthentication.thereWasAnError'), "error");
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
                return axios.get(this.url('sdx.settings.twoFactorAuthentication.qrCodeURL'))
                    .then(response => {
                        if (response.data.svg) {
                            this.qrCode = response.data.svg;
                            this.showingQrCode = true;
                        }
                    })
                    .catch((error) => {
                        return swal(this.trans('sdx.settings.twoFactorAuthentication.sorry'), this.trans('sdx.settings.twoFactorAuthentication.thereWasAnError'), "error");
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
                return axios.post(this.url('sdx.settings.twoFactorAuthentication.recoveryCodesURL'))
                    .then(response => {
                        swal(this.trans('sdx.settings.twoFactorAuthentication.success'), this.trans('sdx.settings.twoFactorAuthentication.recoveryCodesGenerated'), "success");
                        return this.getRecoveryCodes();
                    })
                    .catch((error) => {
                        return swal(this.trans('sdx.settings.twoFactorAuthentication.sorry'), this.trans('sdx.settings.twoFactorAuthentication.thereWasAnError'), "error");
                    });
            },
            getRegenerateRecoveryCodesConfirmation(callback, errorCallback = null) {
                swal({
                    title: this.trans('sdx.settings.twoFactorAuthentication.confirmRegeneration'),
                    text: this.trans('sdx.settings.twoFactorAuthentication.pleaseConfirmRegeneration'),
                    icon: "warning",
                    buttons: {
                        cancel: this.trans('sdx.settings.twoFactorAuthentication.cancel'),
                        confirm: {
                            text: this.trans('sdx.settings.twoFactorAuthentication.confirm'),
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
                    return swal(this.trans('sdx.settings.twoFactorAuthentication.sorry'), this.trans('sdx.settings.twoFactorAuthentication.thereWasAnError'), "error");
                });
            },
            sendPasswordConfirmation(password, callback, errorCallback = null) {
                axios.post(this.url('sdx.settings.twoFactorAuthentication.confirmPasswordURL'), {"password": password})
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
                                return swal(this.trans('sdx.settings.twoFactorAuthentication.sorry'), this.trans('sdx.settings.twoFactorAuthentication.passwordDoesNotMatch'), "error");
                            }
                            return swal(this.trans('sdx.settings.twoFactorAuthentication.sorry'), this.trans('sdx.settings.twoFactorAuthentication.thereWasAnError'), "error");
                        }
                    });
            },
            getPasswordConfirmation(callback, errorCallback = null) {
                swal({
                    title: this.trans('sdx.settings.twoFactorAuthentication.confirmPassword'),
                    text: this.trans('sdx.settings.twoFactorAuthentication.pleaseConfirmPassword'),
                    content: {
                        element: "input",
                        attributes: {
                            placeholder: this.trans('sdx.settings.twoFactorAuthentication.password'),
                            type: "password",
                        },
                    },
                    buttons: {
                        cancel: this.trans('sdx.settings.twoFactorAuthentication.cancel'),
                        confirm: {
                            text: this.trans('sdx.settings.twoFactorAuthentication.confirm'),
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
                    return swal(this.trans('sdx.settings.twoFactorAuthentication.sorry'), this.trans('sdx.settings.twoFactorAuthentication.thereWasAnError'), "error");
                });
            },
            checkPasswordConfirmation(callback, errorCallback = null) {
                axios.get(this.url('sdx.settings.twoFactorAuthentication.confirmedPasswordStatusURL'))
                    .then(response => {
                        return callback(response);
                    })
                    .catch((error) => {
                        if (errorCallback) {
                            return errorCallback(error);
                        }
                        return swal(this.trans('sdx.settings.twoFactorAuthentication.sorry'), this.trans('sdx.settings.twoFactorAuthentication.thereWasAnError'), "error");
                    });
            },
            getDisableTwoFactorAuthenticationConfirmation(callback, errorCallback = null) {
                swal({
                    title: this.trans('sdx.settings.twoFactorAuthentication.confirmDisable'),
                    text: this.trans('sdx.settings.twoFactorAuthentication.pleaseConfirmDisable'),
                    icon: "warning",
                    buttons: {
                        cancel: this.trans('sdx.settings.twoFactorAuthentication.cancel'),
                        confirm: {
                            text: this.trans('sdx.settings.twoFactorAuthentication.disable'),
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
                    return swal(this.trans('sdx.settings.twoFactorAuthentication.sorry'), this.trans('sdx.settings.twoFactorAuthentication.thereWasAnError'), "error");
                });
            },
            getDisableTwoFactorAuthenticationWithCode(callback, errorCallback = null) {
                swal({
                    title: this.trans('sdx.settings.twoFactorAuthentication.confirmAppCode'),
                    text: this.trans('sdx.settings.twoFactorAuthentication.pleaseConfirmAppCode'),
                    content: {
                        element: "input",
                        attributes: {
                            placeholder: this.trans('sdx.settings.twoFactorAuthentication.code'),
                        },
                    },
                    buttons: {
                        cancel: this.trans('sdx.settings.twoFactorAuthentication.cancel'),
                        confirm: {
                            text: this.trans('sdx.settings.twoFactorAuthentication.disable'),
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
                    return swal(this.trans('sdx.settings.twoFactorAuthentication.sorry'), this.trans('sdx.settings.twoFactorAuthentication.thereWasAnError'), "error");
                });
            },
            enable2FA() {
                this.dirty = true;
                axios.post(this.url('sdx.settings.twoFactorAuthentication.toggleURL'))
                    .then(response => {
                        return this.getRecoveryCodes();
                    })
                    .catch((error) => {
                        axios.delete(this.url('sdx.settings.twoFactorAuthentication.toggleURL'));
                        this.dirty = false;
                        return swal(this.trans('sdx.settings.twoFactorAuthentication.sorry'), this.trans('sdx.settings.twoFactorAuthentication.thereWasAnError'), "error");
                    });
            },
            disable2FA() {
                axios.delete(this.url('sdx.settings.twoFactorAuthentication.toggleURL'))
                    .then(response => {
                        return this.getRecoveryCodes();
                    })
                    .catch((error) => {
                        this.dirty = false;
                        return swal(this.trans('sdx.settings.twoFactorAuthentication.sorry'), this.trans('sdx.settings.twoFactorAuthentication.thereWasAnError'), "error");
                    });
            },
            getRecoveryCodes() {
                axios.get(this.url('sdx.settings.twoFactorAuthentication.recoveryCodesURL'))
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
                        return swal(this.trans('sdx.settings.twoFactorAuthentication.success'), this.trans('sdx.settings.twoFactorAuthentication.hasBeenDisabled'), "success");
                    })
                    .catch((error) => {
                        axios.delete(this.url('sdx.settings.twoFactorAuthentication.toggleURL'));
                        this.dirty = false;
                        return swal(this.trans('sdx.settings.twoFactorAuthentication.sorry'), this.trans('sdx.settings.twoFactorAuthentication.thereWasAnError'), "error");
                    });
            },
            getQrCode(callback = null, errorCallback = null) {
                axios.get(this.url('sdx.settings.twoFactorAuthentication.qrCodeURL'))
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
                        axios.delete(this.url('sdx.settings.twoFactorAuthentication.toggleURL'));
                        this.dirty = false;
                        return swal(this.trans('sdx.settings.twoFactorAuthentication.sorry'), this.trans('sdx.settings.twoFactorAuthentication.thereWasAnError'), "error");
                    });
            },
            showConfirmCodeModal(qrCode) {
                var span = document.createElement("span");
                span.innerHTML=qrCode+'<input type="text" inputmode="numeric" pattern="[0-9]*" id="swal-input1" class="swal-content__input mt-3" placeholder="'+this.trans('sdx.settings.twoFactorAuthentication.code')+'" autocomplete="off"><img src="//:0" class="d-none" onerror="setTimeout(function(){ $(\'#swal-input1\').focus();$(\'#swal-input1\').on(\'keydown\', function(event) {if(event.which == 13){$(\'#swal-input1\').parent().parent().parent().parent().find(\'.swal-button--confirm\').trigger(\'click\');}}); }, 500) ">'; // JESUS! This is to get around sweetalert limitations
                swal({
                    title: this.trans('sdx.settings.twoFactorAuthentication.confirmAppCode'),
                    text: this.trans('sdx.settings.twoFactorAuthentication.enterAuthenticatorAppCode'),
                    content: {
                        element: span
                    },
                    buttons: {
                        confirm: {
                            text: this.trans('sdx.settings.twoFactorAuthentication.confirm'),
                            closeModal: false,
                        }
                    },
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                })
                .then(submittedCode => {
                    if(!this.twoFactorEnabled) {
                        return this.confirmCode();
                    }
                })
                .catch((error) => {
                    axios.delete(this.url('sdx.settings.twoFactorAuthentication.toggleURL'));
                    this.dirty = false;
                    return swal(this.trans('sdx.settings.twoFactorAuthentication.sorry'), this.trans('sdx.settings.twoFactorAuthentication.thereWasAnError'), "error");
                });
            },
            confirmCode() {
                axios.post(this.url('sdx.settings.twoFactorAuthentication.enableCheckURL'), {"code": $('#swal-input1').val(), "user_id": sdx.auth.user.id})
                    .then(response => {
                        this.twoFactorEnabled = true;
                        this.showingRecoveryCodes = true;
                        this.dirty = false;
                        return swal(this.trans('sdx.settings.twoFactorAuthentication.success'), this.trans('sdx.settings.twoFactorAuthentication.hasBeenEnabled'), "success");
                    })
                    .catch((error) => {
                        axios.delete(this.url('sdx.settings.twoFactorAuthentication.toggleURL'));
                        this.dirty = false;
                        if (error.response) {
                            if (error.response.status === 401) {
                                return swal(this.trans('sdx.settings.twoFactorAuthentication.sorry'), this.trans('sdx.settings.twoFactorAuthentication.codeDoesNotMatch'), "error");
                            }
                        }
                        return swal(this.trans('sdx.settings.twoFactorAuthentication.sorry'), this.trans('sdx.settings.twoFactorAuthentication.thereWasAnError'), "error");
                    });
            },
        }
    }
</script>
