const el = wp.element.createElement;
const {
    registerBlockType,
    RichText,
    AlignmentToolbar,
    BlockControls,
    InspectorControls
} = wp.blocks;
const {
    Tooltip,
    TextControl,
    ToggleControl,
    FormTokenField,
    Button
} = wp.components;

registerBlockType('fhgnewsonline/poll', {
    title: 'Umfrage',
    description: 'Erstellt eine Umfrage',
    icon: 'chart-bar',
    category: 'common',
    attributes: {
        id: {
            type: 'number',
            default: 0,
        },
        multi: {
            type: 'boolean',
            default: false,
        },
        question: {
            type: 'string',
        },
        answers: {
            type: 'array',
        }
    },
    edit: function (props) {
        var id = props.attributes.id;
        var multi = props.attributes.multi;
        var question = props.attributes.question;
        var answers = props.attributes.answers;

        return el('div', {className: props.className}, [
            el('h4', null, 'Umfrage'),
            el(TextControl, {
                value: id,
                type: 'number',
                onChange: function (newVal) {
                    console.log(newVal);
                    props.setAttributes({id: parseInt(newVal)});
                },
                label: 'ID:',
                help: 'Wenn es mehrere Umfrage-Blöcke in einem Beitrag gibt, muss die ID bei jeder Umfrage unterschiedlich sein',
                placeholder: 'ID eingeben',
                className: 'fhgnewsonline-poll-id'
            }),
            el(ToggleControl, {
                checked: multi,
                onChange: function (newVal) {
                    props.setAttributes({multi: newVal});
                },
                help: (multi ? 'Es können mehrere Antworten gleichzeitig ausgewählt werden.' : 'Es kann nur eine Antwort gleichzeitig ausgewählt werden.'),
                label: 'Multi-Antwort Umfrage',
                className: 'fhgnewsonline-poll-multi'
            }),
            el(TextControl, {
                value: question,
                onChange: function (newVal) {
                    props.setAttributes({question: newVal});
                },
                placeholder: 'Frage eingeben',
                className: 'fhgnewsonline-poll-question'
            }),
            el(FormTokenField, {
                value: answers,
                onChange: function (tokens) {
                    props.setAttributes({answers: tokens});
                },
                placeholder: 'Antworten eingeben',
                className: 'fhgnewsonline-poll-answer'
            }),
            el(Button, {
                isLink: true,
                onClick: function () {
                    if (confirm('Bist du dir sicher, dass du alle Stimmen dieser Umfrage löschen möchtest?')) {
                        jQuery.ajax({
                                type: 'POST',
                                url: php_vars.ajax_url,
                                data: {
                                    action: 'reset_poll',
                                    post_id: jQuery("#post_ID").val(),
                                    poll_id: id
                                },
                                success: function (data) {
                                    alert('Alle Stimmen dieser Umfrage wurden gelöscht.');
                                }
                            }
                        );
                    }
                },
                className: 'fhgnewsonline-poll-reset'
            }, 'Umfrage zurücksetzen')
        ]);
    },
    save: function () {
        return null;
    },
});