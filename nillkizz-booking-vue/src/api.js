// class API {
//   getDoctors() {
//     return [];
//   }
// }
import demoData from "@/demo_data.json";
class DemoAPI {
  async getConfig() {
    return new Promise((res) => {
      setTimeout(() => {
        return res();
      }, 400);
    }).then(() => {
      return {
        pagination: {
          enabled: true,
          perPage: 10,
        },
      };
    });
  }
  async getDoctors() {
    return new Promise((res) => {
      setTimeout(() => {
        return res();
      }, 400);
    }).then(() => {
      return demoData.persons;
    });
  }
  async getSpecialties() {
    return new Promise((res) => {
      setTimeout(() => {
        return res();
      }, 400);
    }).then(() => {
      return demoData.specs;
    });
  }
  async getTimeslots() {
    return new Promise((res) => {
      setTimeout(() => {
        return res();
      }, 400);
    }).then(() => {
      return demoData.timeslots;
    });
  }
}
const api = new DemoAPI();
export default api;
