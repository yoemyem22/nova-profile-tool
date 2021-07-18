<template>
    <loading-view :loading="loading">
        <heading class="mb-3">ធ្វើបច្ចុប្បន្នភាព{{__('Profile')}}</heading>

        <card class="overflow-hidden">
            <form @submit="saveProfile">
                <!-- Validation Errors -->
                <validation-errors :errors="validationErrors"/>

                <!-- Fields -->
                <div v-for="field in fields">
                    <component
                        :is="'form-' + field.component"
                        :errors="validationErrors"
                        :resource-name="resourceName"
                        :field="field"
                        :via-resource="viaResource"
                        :via-resource-id="viaResourceId"
                        :via-relationship="viaRelationship"
                    />
                </div>

                <!-- Create Button -->
                <div class="bg-30 flex px-8 py-4">
                    <button dusk="create-and-add-another-button" class="ml-auto btn btn-default btn-primary mr-3">
                        រក្សាទុក
                    </button>
                </div>
            </form>
        </card>
    </loading-view>
</template>

<script>
    import {Errors} from 'laravel-nova'

    export default {

        data: () => ({
            loading: true,
            fields: [],
            validationErrors: new Errors(),
        }),

        created() {
            this.getFields()
        },

        methods: {
            /**
             * Get the available fields for the resource.
             */
            async getFields() {
                this.fields = []

                const {data: fields} = await Nova.request().get(
                    '/nova-vendor/nova-profile-tool/'
                )

                this.fields = fields
                this.loading = false
            },

            /**
             * Saves the user's profile
             */
            async saveProfile(e) {
                try {
                    e.preventDefault()
                    this.loading = true
                    const response = await this.createRequest()
                    this.loading = false

                    Nova.success(response.data.msg)

                    // Reset the form by refetching the fields
                    this.getFields()

                    this.validationErrors = new Errors()
                } catch (error) {
                    window.scrollTo(0, 0)
                    this.loading = false
                    if (error.response.status == 422) {
                        this.validationErrors = new Errors(error.response.data.errors)
                        this.handleResponseError(error)
                    }
                }
            },

            handleResponseError(error) {
                if (error.response.status === 422) {
                    this.validationErrors = new Errors(error.response.data.errors)
                    Nova.error(this.__('There was a problem submitting the form.'))
                } else if (error.response.status === 500) {
                    Nova.error(this.__('There was a problem submitting the form.'))
                } else {
                    Nova.error(
                        this.__('There was a problem submitting the form.') +
                        ' "' +
                        error.response.statusText +
                        '"'
                    )
                }
            },

            /**
             * Send a create request to update the user's profile data
             */
            createRequest() {
                return Nova.request().post(
                    '/nova-vendor/nova-profile-tool/',
                    this.createResourceFormData()
                )
            },

            /**
             * Create the form data for creating the resource.
             */
            createResourceFormData() {
                return _.tap(new FormData(), formData => {
                    _.each(this.fields, field => {
                        field.fill(formData)
                    })
                })
            },
        },
    }
</script>
