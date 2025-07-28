<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
    authUser: Object,
    userDonations: Array,
    userCampaigns: Array,
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Profile
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >
                    <DeleteUserForm class="max-w-xl" />
                </div>

                <!-- User Donations -->
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <div class="max-w-4xl">
                        <h3 class="text-lg font-semibold mb-4">My Donations</h3>
                        <ul v-if="userDonations.length">
                            <li
                                v-for="donation in userDonations"
                                :key="donation.id"
                                class="mb-2 text-sm text-gray-700"
                            >
                                Donated ${{ donation.amount.toFixed(2) }} to 
                                <strong>{{ donation.campaign?.title ?? 'Deleted Campaign' }}</strong>
                            </li>
                        </ul>
                        <p v-else class="text-gray-500">No donations yet.</p>
                    </div>
                </div>

                <!-- User Campaigns -->
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <div class="max-w-4xl">
                        <h3 class="text-lg font-semibold mb-4">My Campaigns</h3>
                        <ul v-if="userCampaigns.length">
                            <li
                                v-for="campaign in userCampaigns"
                                :key="campaign.id"
                                class="mb-2 text-sm text-gray-700"
                            >
                                <strong>{{ campaign.title }}</strong> — ${{ campaign.goal_amount }} goal
                            </li>
                        </ul>
                        <p v-else class="text-gray-500">You haven’t created any campaigns yet.</p>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
