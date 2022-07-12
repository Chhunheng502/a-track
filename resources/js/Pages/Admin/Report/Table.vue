<script>
import { defineComponent } from 'vue'

export default defineComponent({
    props: {
        attendanceData: Object
    },

    data() {
        return {
            thItems: [
                {
                    name: 'Name'
                },
                {
                    name: 'Email'
                },
            ]
        }
    },

    computed: {
        isWeekly() {
            const params = new URLSearchParams(window.location.search)

            if (params.has('week')) {
                return params.get('week') != 'all';
            }
        }
    },

    created() {
        if (this.isWeekly) {
            this.attendanceData.sessions.forEach((session, index) => {
                this.thItems.push({
                    name: 'Session ' + (index + 1) 
                })
            });
        } else {
            this.thItems.push(
                {
                    name: 'Total Presences'
                },
                {
                    name: 'Total Absences'
                },
            )
        }
    },

    methods: {
        tableToCSV() {
 
            // Variable to store the final csv data
            var csv_data = [];
 
            // Get each row data
            var rows = document.getElementsByTagName('tr');
            for (var i = 0; i < rows.length; i++) {
 
                // Get each column data
                var cols = rows[i].querySelectorAll('td,th');
 
                // Stores each csv row data
                var csvrow = [];
                for (var j = 0; j < cols.length; j++) {
 
                    // Get the text data of each cell
                    // of a row and push it to csvrow
                    var currentNode = cols[j];
                    while(currentNode.firstElementChild) {

                        if (
                            currentNode.getAttribute('id') == 'profile-picture' ||
                            currentNode.getAttribute('id') == 'today-status'
                        ) {
                            currentNode = currentNode.childNodes[1];
                        } else {
                            currentNode = currentNode.firstElementChild;
                        }
                    }

                    csvrow.push(currentNode.innerHTML);
                }
 
                // Combine each column value with comma
                csv_data.push(csvrow.join(","));
            }
 
            // Combine each row data with new line character
            csv_data = csv_data.join('\n');
 
            // Call this function to download csv file 
            this.downloadCSVFile(csv_data);
        },
 
        downloadCSVFile(csv_data) {
 
            // Create CSV file object and feed
            // our csv_data into it
            var CSVFile = new Blob([csv_data], {
                type: "text/csv"
            });
 
            // Create to temporary link to initiate
            // download process
            var temp_link = document.createElement('a');
 
            // Download csv file
            temp_link.download = "records.csv";
            var url = window.URL.createObjectURL(CSVFile);
            temp_link.href = url;
 
            // This link should not be displayed
            temp_link.style.display = "none";
            document.body.appendChild(temp_link);
 
            // Automatically click the link to
            // trigger download
            temp_link.click();
            document.body.removeChild(temp_link);
        }
    }
})
</script>

<template>
    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th
                            v-for="item in thItems"
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                        >
                            {{ item.name }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="registration in attendanceData.registrations"
                    >
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div id="profile-picture" class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10">
                                    <img class="w-full h-full rounded-full"
                                        :src="registration.student.photo_url"
                                        alt="profile" />
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{ registration.student.name }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">
                                {{ registration.student.email }}
                            </p>
                        </td>
                        <td
                            v-if="isWeekly && registration.student.attendances.length"
                            v-for="attendance in registration.student.attendances"
                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm"
                        >
                            <span
                                class="relative inline-block px-3 py-1 font-semibold leading-tight cursor-pointer"
                                :class="[attendance.present ? 'text-green-900' : 'text-red-900']"
                            >
                                <span  
                                    aria-hidden
                                    class="absolute inset-0 bg-red-200 opacity-50 rounded-full"
                                    :class="[attendance.present ? 'bg-green-200' : 'bg-red-200']"
                                >
                                </span>
                                <span class="relative">{{ attendance.present ? 'Present' : 'Absent' }}</span>
                            </span>
                        </td>
                        <td
                            v-if="isWeekly && ! registration.student.attendances.length"
                            v-for="session in attendanceData.sessions"
                            class="px-5 py-5 border-b border-gray-200 bg-white text-sm"
                        >
                            <p class="text-gray-900 whitespace-no-wrap">
                                No Data
                            </p>
                        </td>
                        <td v-if="! isWeekly" class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">
                                {{ registration.student.attendances.filter(item => item.present).length }}
                            </p>
                        </td>
                        <td v-if="! isWeekly" class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">
                                {{ registration.student.attendances.filter(item => !item.present).length }}
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>