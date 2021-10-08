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

    const mapTimeslots = new Map(
      fetched_timeslots.map((ts) => [parseInt(ts.doctor_id), ts])
    );
    const mapSpecs = new Map(fetched_specs.map((s) => [s.id, s]));

    const doctors = fetched_doctors.map((doctor) => {
      doctor.id = parseInt(doctor.id);
      const now = DateTime.now().startOf("day");

      doctor.spec = doctor.specialty.map((specId) => mapSpecs.get(specId));

      let mapCalendar = new Map();

      if (mapTimeslots.has(doctor.id)) {
        // Make calendar
        const days = mapTimeslots.get(doctor.id).slots;
        if (days && Object.keys(days).length > 0) {
          mapCalendar = new Map(
            Object.entries(days).map((slot) => {
              const dayISO = slot[0],
                day = new Map(slot[1].map((d) => [d.time, d]));

              day.dt = DateTime.fromISO(dayISO).setLocale("ru");
              day.ISO = dayISO;
              day.disabled = day.dt.ts < now || day.size < 1;
              // day.disabled = day.size < 1;
              day.isToday = day.dt.ts == now.ts;
              return [dayISO, day];
            })
          );
        }
      }
      mapCalendar.isActive = Array.from(mapCalendar.values()).some(
        (day) => !day.disabled
      );
      mapCalendar.selected = { dayISO: undefined, slot: undefined };
      doctor.calendar = mapCalendar;

      return doctor;
    });
    const mapDoctors = new Map(doctors.map((doc) => [doc.id, doc]));
    const specs = fetched_specs.filter((spec) =>
      doctors.some((doc) => doc.specialty.includes(spec.id))
    );
    return { doctors, mapDoctors, specs };
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
