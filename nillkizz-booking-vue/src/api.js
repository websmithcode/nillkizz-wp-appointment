// class API {
//   getDoctors() {
//     return [];
//   }
// }
import demoData from "@/demo_data.json";
import { DateTime } from "luxon";
class DemoAPI {
  async getDoctorsAndSpecs() {
    const fetched_doctors = await this.getDoctors();
    const fetched_specs = await this.getSpecialties();
    const fetched_timeslots = await this.getTimeslots();

    const mappedSpecs = {};
    fetched_specs.forEach((s) => (mappedSpecs[s.id] = s));

    const doctors = fetched_doctors.map((doctor) => {
      const now = DateTime.now().startOf("day");

      doctor.spec = doctor.specialty.map((specId) => mappedSpecs[specId]);

      const timeslots = fetched_timeslots.filter(
        (ts) => ts.doctor_id == doctor.id
      )[0];

      let calendar = [];
      const days = timeslots?.slots;
      if (days && Object.keys(days).length > 0) {
        const daysEntries = Object.entries(days);
        calendar = daysEntries.map((slot) => {
          const day = slot[1],
            dayISO = slot[0];
          day.dt = DateTime.fromISO(dayISO).setLocale("ru");
          // day.disabled = day.dt.ts < now || day.length < 1;
          day.disabled = day.length < 1;
          day.isToday = day.dt.ts == now.ts;
          day.selected = false;
          return day;
        });
      }
      calendar.isActive = calendar.some((day) => !day.disabled);
      doctor.calendar = calendar;

      return doctor;
    });
    const specs = fetched_specs.filter((spec) =>
      doctors.some((doc) => doc.specialty.includes(spec.id))
    );
    return { doctors, specs };
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
