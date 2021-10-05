// class API {
//   getDoctors() {
//     return [];
//   }
// }
import demoData from "@/demo_data.json";
class DemoAPI {
  async getData() {
    const fetched_doctors = await this.getDoctors();
    const fetched_specs = await this.getSpecialties();
    const fetched_timeslots = await this.getTimeslots();

    const mappedSpecs = {};
    fetched_specs.forEach((s) => (mappedSpecs[s.id] = s));

    const doctors = fetched_doctors.map((doc) => {
      doc.spec = doc.specialty.map((specId) => mappedSpecs[specId]);
      doc.timeslots = fetched_timeslots.filter((ts) => ts.doctor_id == doc.id);
      return doc;
    });
    const specs = fetched_specs.filter((spec) =>
      doctors.some((doc) => doc.specialty.includes(spec.id))
    );
    return { doctors: doctors, specs: specs };
  }
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
      return demoData.persons.slice(0, 70);
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
