(function (wp) {
    "use strict";

    const { createElement: el, Fragment, useState } = wp.element;

    const STEP_TITLES = [
        "Welcome & AI Provider Setup",
        "Business Information",
        "AI-Suggested Service Areas",
        "Media Upload",
        "Design System",
        "AI Tone & Brand Voice",
        "Review & Launch"
    ];

    const DEFAULT_STATE = {
        current_step: 0,
        ai_provider: "claude",
        ai_model: "claude-sonnet-4",
        ai_api_key: "",
        business_name: "",
        business_city: "",
        business_state: "",
        business_phone: "",
        business_email: "",
        business_description: "",
        manual_areas: "",
        font_pairing: "classic-luxury",
        color_scheme: "midnight-gold",
        brand_voice: "sophisticated-refined",
        prohibited_phrases: "cheap\nbudget\naffordable\nlow-cost\nbasic",
        required_disclaimers: "Prices subject to change without notice",
        content_length: "standard"
    };

    const providerModels = {
        claude: ["claude-opus-4", "claude-sonnet-4", "claude-haiku-4"],
        openai: ["gpt-4o", "gpt-4o-mini", "gpt-4-turbo"],
        gemini: ["gemini-1.5-pro", "gemini-1.5-flash"]
    };

    function Field(props) {
        return el("p", null,
            el("label", { htmlFor: props.id }, el("strong", null, props.label)),
            el("br"),
            el("input", {
                id: props.id,
                className: "regular-text",
                type: props.type || "text",
                value: props.value || "",
                onChange: function (e) { props.onChange(e.target.value); }
            })
        );
    }

    function SelectField(props) {
        return el("p", null,
            el("label", { htmlFor: props.id }, el("strong", null, props.label)),
            el("br"),
            el("select", {
                id: props.id,
                value: props.value,
                onChange: function (e) { props.onChange(e.target.value); }
            },
            props.options.map(function (item) {
                return el("option", { key: item.value, value: item.value }, item.label);
            }))
        );
    }

    function TextareaField(props) {
        return el("p", null,
            el("label", { htmlFor: props.id }, el("strong", null, props.label)),
            el("br"),
            el("textarea", {
                id: props.id,
                className: "large-text",
                rows: props.rows || 4,
                value: props.value || "",
                onChange: function (e) { props.onChange(e.target.value); }
            })
        );
    }

    function WizardApp() {
        const initial = Object.assign({}, DEFAULT_STATE, limouxWizard.state || {});
        const [state, setState] = useState(initial);
        const [step, setStep] = useState(initial.current_step || 0);
        const [busy, setBusy] = useState(false);
        const [notice, setNotice] = useState("");

        const saveState = function (nextState, callback) {
            setBusy(true);
            window.jQuery.post(limouxWizard.ajaxUrl, {
                action: "limoux_wizard_save_state",
                nonce: limouxWizard.nonce,
                state: JSON.stringify(nextState)
            }).done(function () {
                if (callback) {
                    callback();
                }
            }).always(function () {
                setBusy(false);
            });
        };

        const updateState = function (patch) {
            setState(Object.assign({}, state, patch));
        };

        const nextStep = function () {
            const next = Math.min(step + 1, STEP_TITLES.length - 1);
            const nextState = Object.assign({}, state, { current_step: next });
            setState(nextState);
            saveState(nextState, function () { setStep(next); });
        };

        const prevStep = function () {
            setStep(Math.max(0, step - 1));
        };

        const skipStep = function () {
            const skipped = Object.assign({}, state.skipped_steps || {}, { [step]: true });
            updateState({ skipped_steps: skipped });
            nextStep();
        };

        const testConnection = function () {
            setBusy(true);
            setNotice("");
            window.jQuery.post(limouxWizard.ajaxUrl, {
                action: "limoux_wizard_test_ai",
                nonce: limouxWizard.nonce,
                provider: state.ai_provider,
                model: state.ai_model,
                api_key: state.ai_api_key
            }).done(function (res) {
                if (res.success) {
                    setNotice("AI connection successful.");
                } else {
                    setNotice((res.data && res.data.message) ? res.data.message : "Connection failed.");
                }
            }).fail(function () {
                setNotice("Connection failed.");
            }).always(function () {
                setBusy(false);
            });
        };

        const generateAreas = function () {
            setBusy(true);
            setNotice("");
            window.jQuery.post(limouxWizard.ajaxUrl, {
                action: "limoux_wizard_generate_service_areas",
                nonce: limouxWizard.nonce,
                manual_areas: state.manual_areas
            }).done(function (res) {
                if (res.success) {
                    setNotice("Created " + res.data.count + " draft service areas.");
                } else {
                    setNotice("Unable to generate service areas.");
                }
            }).always(function () {
                setBusy(false);
            });
        };

        const launchSetup = function () {
            const finalState = Object.assign({}, state, { completed: true, current_step: STEP_TITLES.length - 1 });
            setState(finalState);
            saveState(finalState, function () {
                window.jQuery.post(limouxWizard.ajaxUrl, {
                    action: "limoux_wizard_launch",
                    nonce: limouxWizard.nonce
                }).done(function (res) {
                    if (res.success && res.data && res.data.redirect) {
                        window.location = res.data.redirect;
                    }
                });
            });
        };

        const stepContent = function () {
            if (step === 0) {
                const modelOptions = (providerModels[state.ai_provider] || []).map(function (model) {
                    return { value: model, label: model };
                });
                return el(Fragment, null,
                    SelectField({ id: "ai_provider", label: "AI Provider", value: state.ai_provider, onChange: function (value) { updateState({ ai_provider: value, ai_model: providerModels[value][0] }); }, options: [
                        { value: "claude", label: "Claude" },
                        { value: "openai", label: "OpenAI" },
                        { value: "gemini", label: "Gemini" }
                    ] }),
                    SelectField({ id: "ai_model", label: "Model", value: state.ai_model, onChange: function (value) { updateState({ ai_model: value }); }, options: modelOptions }),
                    Field({ id: "ai_api_key", label: "API Key", type: "password", value: state.ai_api_key, onChange: function (value) { updateState({ ai_api_key: value }); } }),
                    el("p", null, el("button", { className: "button", onClick: testConnection, disabled: busy }, busy ? "Testing..." : "Test Connection"))
                );
            }

            if (step === 1) {
                return el(Fragment, null,
                    Field({ id: "business_name", label: "Business Name", value: state.business_name, onChange: function (value) { updateState({ business_name: value }); } }),
                    Field({ id: "business_city", label: "City", value: state.business_city, onChange: function (value) { updateState({ business_city: value }); } }),
                    Field({ id: "business_state", label: "State", value: state.business_state, onChange: function (value) { updateState({ business_state: value }); } }),
                    Field({ id: "business_phone", label: "Business Phone", value: state.business_phone, onChange: function (value) { updateState({ business_phone: value }); } }),
                    Field({ id: "business_email", label: "Business Email", type: "email", value: state.business_email, onChange: function (value) { updateState({ business_email: value }); } }),
                    TextareaField({ id: "business_description", label: "Brief Business Description", value: state.business_description, onChange: function (value) { updateState({ business_description: value }); } })
                );
            }

            if (step === 2) {
                return el(Fragment, null,
                    TextareaField({ id: "manual_areas", label: "Manual Service Areas (one per line)", rows: 6, value: state.manual_areas, onChange: function (value) { updateState({ manual_areas: value }); } }),
                    el("p", null, el("button", { className: "button", onClick: generateAreas, disabled: busy }, busy ? "Generating..." : "Create Draft Service Areas"))
                );
            }

            if (step === 3) {
                return el("p", null, "Upload media from Media Library. Purpose tagging and optimization are available after upload.");
            }

            if (step === 4) {
                return el(Fragment, null,
                    SelectField({ id: "font_pairing", label: "Font Pairing", value: state.font_pairing, onChange: function (value) { updateState({ font_pairing: value }); }, options: [
                        { value: "classic-luxury", label: "Classic Luxury" },
                        { value: "modern-executive", label: "Modern Executive" },
                        { value: "refined-serif", label: "Refined Serif" },
                        { value: "contemporary", label: "Contemporary" },
                        { value: "bold-prestige", label: "Bold Prestige" }
                    ] }),
                    SelectField({ id: "color_scheme", label: "Color Scheme", value: state.color_scheme, onChange: function (value) { updateState({ color_scheme: value }); }, options: [
                        { value: "midnight-gold", label: "Midnight Gold" },
                        { value: "obsidian-silver", label: "Obsidian Silver" },
                        { value: "navy-champagne", label: "Navy & Champagne" },
                        { value: "charcoal-emerald", label: "Charcoal & Emerald" },
                        { value: "midnight-rose-gold", label: "Midnight & Rose Gold" },
                        { value: "black-white", label: "Pure Black & White" }
                    ] })
                );
            }

            if (step === 5) {
                return el(Fragment, null,
                    SelectField({ id: "brand_voice", label: "Brand Voice", value: state.brand_voice, onChange: function (value) { updateState({ brand_voice: value }); }, options: [
                        { value: "sophisticated-refined", label: "Sophisticated & Refined" },
                        { value: "warm-approachable", label: "Warm & Approachable" },
                        { value: "corporate-professional", label: "Corporate & Professional" },
                        { value: "exclusive-aspirational", label: "Exclusive & Aspirational" },
                        { value: "classic-timeless", label: "Classic & Timeless" }
                    ] }),
                    TextareaField({ id: "prohibited_phrases", label: "Prohibited Phrases", value: state.prohibited_phrases, onChange: function (value) { updateState({ prohibited_phrases: value }); } }),
                    TextareaField({ id: "required_disclaimers", label: "Required Disclaimers", value: state.required_disclaimers, onChange: function (value) { updateState({ required_disclaimers: value }); } }),
                    SelectField({ id: "content_length", label: "Content Length", value: state.content_length, onChange: function (value) { updateState({ content_length: value }); }, options: [
                        { value: "short", label: "Short & Punchy" },
                        { value: "standard", label: "Standard" },
                        { value: "long", label: "Long-Form" }
                    ] })
                );
            }

            return el("div", null,
                el("ul", null,
                    el("li", null, "AI Provider: " + state.ai_provider + " / " + state.ai_model),
                    el("li", null, "Business: " + (state.business_name || "(not set)")),
                    el("li", null, "Location: " + [state.business_city, state.business_state].filter(Boolean).join(", ")),
                    el("li", null, "Font/Color: " + state.font_pairing + " / " + state.color_scheme),
                    el("li", null, "Brand Voice: " + state.brand_voice)
                )
            );
        };

        return el("div", { className: "limoux-wizard" },
            el("div", { className: "limoux-wizard__header" },
                el("h1", null, "Limoux Setup Wizard"),
                el("p", null, "Step " + (step + 1) + " of " + STEP_TITLES.length + " - " + STEP_TITLES[step])
            ),
            el("div", { className: "limoux-wizard__content" },
                stepContent(),
                notice ? el("p", null, notice) : null
            ),
            el("div", { className: "limoux-wizard__footer" },
                el("div", null,
                    step > 0 ? el("button", { className: "button", onClick: prevStep, disabled: busy }, "Back") : null,
                    step < STEP_TITLES.length - 1 ? el("button", { className: "button", onClick: skipStep, disabled: busy, style: { marginLeft: "8px" } }, "Skip this step") : null
                ),
                el("div", null,
                    step < STEP_TITLES.length - 1
                        ? el("button", { className: "button button-primary", onClick: nextStep, disabled: busy }, busy ? "Saving..." : "Save & Continue")
                        : el("button", { className: "button button-primary", onClick: launchSetup, disabled: busy }, busy ? "Saving..." : "Launch Setup")
                )
            )
        );
    }

    window.addEventListener("DOMContentLoaded", function () {
        const mount = document.getElementById("limoux-wizard-root");
        if (!mount) {
            return;
        }

        wp.element.render(el(WizardApp), mount);
    });
}(window.wp));
