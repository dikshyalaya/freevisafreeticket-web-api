import Api from './Api';

export default {
    getApplicants(page,limit,filter, formData){
        // return Api().get('/company/web-api/getApplicants', {params: {page: page, limit: limit, filter: filter, form_data: formData}});
        return Api().get('/company/web-api/getApplicants?page=' + page + '&limit='+ limit + '&filter=' + filter);
    },

    getDataSets(){
        return Api().get('/company/web-api/getDataSets');
    },

    createNewJob(formData){
        return Api().post('/web-api/job/create', formData);
    },

    updateBulkStatus(formData){
        return Api().post('/company/web-api/bulk-status-update', formData);
    },

    downloadBulkCv(formData, config){
        return Api().post('/company/web-api/bulk-cv-download', formData, config);
    },
    deleteBulkApplication(formData){
        return Api().delete('/company/web-api/bulk-application-delete', formData);
    },
    interviewSchedule(formData){
        return Api().post('/company/web-api/bulk-interview-schedule', formData);
    },
    getApplicantFilterData(filterId){
        return Api().get('/company/web-api/get-applicant-filter', filterId);
    },
    saveAdvancedFilter(formData){
        return Api().post('/company/web-api/save-advaced-filter', formData);
    },
}
